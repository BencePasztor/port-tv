<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Builder;

class ScheduleController extends Controller
{

    public function index(Request $request)
    {
        $channel_id = $request->query('channel_id', 'tvchannel-5');
        $date = $request->query('date', date('Y-m-d'));

        //Get the records where the "start" is on $date or the "end" is on date and "is_overlapping" is true
        $schedules = Schedule::where('channel_id', $channel_id)
            ->where(function (Builder $query) use ($date) {
                $query
                    ->whereDate('start', $date)
                    ->orWhere(function (Builder $query) use ($date) {
                        $query
                            ->whereDate('end', $date)
                            ->where('is_overlapping', true);
                    });
            })
            ->orderBy('start', 'asc')
            ->get();

        //Get the active dates
        $activeDates = Schedule::getActiveDates();

        return view('index', [
            'schedules' => $schedules,
            'activeDates' => $activeDates,
            'channels' => Schedule::DEFAULT_CHANNEL_IDS
        ]);
    }
}
