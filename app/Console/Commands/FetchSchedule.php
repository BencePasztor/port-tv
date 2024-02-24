<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Schedule;
use Exception;
use Illuminate\Support\Carbon;

class FetchSchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:fetch {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches and stores the schedule of the 5 default tv channels from PORT on the given date.';

    /**
     * Base URL for the PORT API
     */
    const BASE_URL = "http://port.hu/tvapi";


    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get the date from the argument, if it's missing use the current date
        $date = $this->argument('date') ?? date('Y-m-d');

        try {
            // Fetch the schedule for the given date
            $scheduleRequest = $this->fetchSchedule($date);

            if ($scheduleRequest['success']) {
                // Update or insert the fetched data into the DB
                Schedule::upsert($scheduleRequest['data'], ['id']);

                $this->info("Schedule fetched for $date");
                return Command::SUCCESS;
            } else {
                throw new Exception($scheduleRequest['message']);
            }
        } catch (Exception $e) {
            // Print the exception message to the console
            $this->error("Fetch failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Fetches the schedule from the API for a given date.
     *
     * @param string $date The date for which the schedule is to be fetched in Y-m-d format.
     * @return array An array containing success status, data, and the message in case an error occurs.
     */
    private function fetchSchedule(String $date)
    {
        $response = Http::withoutVerifying()->get(self::BASE_URL, [
            "date" => $date,
            "channel_id" => Schedule::DEFAULT_CHANNEL_IDS
        ]);

        if ($response->successful()) {
            return [
                'success' => true,
                'data' => $this->processScheduleData($response->json(), $date)
            ];
        }

        return [
            'success' => false,
            'status' => $response->status(),
            'message' => $response->body()
        ];
    }

    /**
     * Transform the fetched schedule data into a more readable format.
     *
     * @param array $data The fetched schedule data.
     * @param string $date The date for which the schedule is to be fetched in Y-m-d format.
     * @return array The transformed schedule data.
     */
    private function processScheduleData($data, $date)
    {
        $processedSchedule = [];

        foreach ($data['channels'] as $channel) {
            foreach ($channel['programs'] as $show) {
                //Append item to the array if it starts on the same date as $date or if it's overlapping
                if (Carbon::parse($show['start_datetime'])->format('Y-m-d') === $date || $show['is_overlapping']) {
                    $processedSchedule[] = [
                        'id' => $show['id'], //The id for the API is used as a primary key
                        'channel_id' => $channel['id'],
                        'channel_name' => $channel['name'],
                        'start' => Carbon::parse($show['start_datetime'])->toDateTimeString(),
                        'end' => Carbon::parse($show['end_datetime'])->toDateTimeString(),
                        'is_overlapping' => $show['is_overlapping'],
                        'title' => $show['title'],
                        'short_description' => $show['short_description'],
                        'age_limit' => $show['restriction']['age_limit'],
                    ];
                }
            }
        }

        return $processedSchedule;
    }
}
