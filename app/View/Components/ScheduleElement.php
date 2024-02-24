<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Schedule;

class ScheduleElement extends Component
{
    /**
     * Create a new component instance.
     * @param Schedule $schedule The schedule record
     * @param int $index The index of the schedule record used for formatting overlapping tv shows
     */
    public function __construct(public Schedule $schedule, public int $index)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.schedule-element');
    }
}
