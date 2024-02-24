<li @class([ 
    "p-3 flex gap-3" , 
    "opacity-50 bg-gray-100"=> $schedule->is_overlapping && $index === 0
    ])>
    <div class="flex-none">
        <p class="text-lg">@if($schedule->is_overlapping && $index === 0)(E)@endif{{$schedule->start_time}}</p>
    </div>
    <div class="flex-grow">
        <p class="text-lg">{{$schedule->title}}</p>
        <p class="text-xs">{{$schedule->short_description}}</p>
    </div>
    <div class="flex-none">
        <p @class([ 
            "size-6 rounded-full border-2 flex items-center justify-center text-xs font-bold" , 
            "border-yellow-500"=> in_array($schedule->age_limit, [12, 16]),
            "border-green-500" => $schedule->age_limit === 0,
            "border-red-500" => $schedule->age_limit === 18,
            ])>{{$schedule->age_limit}}</p>
    </div>
</li>