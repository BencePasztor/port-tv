<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Schedule extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $casts = [
        'is_overlapping' => 'boolean',
    ];

    /**
     * Channel IDs for the first 5 TV channels
     */
    public const DEFAULT_CHANNEL_IDS = [
        "RTL" => "tvchannel-5",
        "TV2" => "tvchannel-3",
        "VIASAT3" => "tvchannel-21",
        "Duna" => "tvchannel-6",
        "Duna World" => "tvchannel-103"
    ];

    protected $guarded = [];

    /**
     * Get only the time from the start
     */
    protected function getStartTimeAttribute()
    {
        return Carbon::parse($this->start)->format('H:i');
    }

    /**
     * Returns all dates that have non overlapping tv shows
     * @return array An array of dates
     */
    public static function getActiveDates()
    {
        $dates = Schedule::where('is_overlapping', false)
            ->selectRaw('DATE(start) as date')
            ->distinct()
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->toArray();

        return $dates;
    }
}
