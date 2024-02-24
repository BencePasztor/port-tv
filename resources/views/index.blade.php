@extends('layout')

@section('head')
<script>
    // Submit the form when the value of the select element changes
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('#schedule-form select').forEach(selectElement => {
            selectElement.addEventListener('change', () => {
                document.getElementById('schedule-form').submit()
            })
        })
    })
</script>
@endsection

@section('content')
<div class="p-4 bg-gray-200 my-4">
    <form id="schedule-form">
        <div class="flex gap-4">
            <div>
                <label class="block" for="channel_id">Csatorna</label>
                <select name="channel_id" id="channel_id" placeholder="Csatorna" class="px-3 py-2 border border-gray-500">
                    @foreach($channels as $name => $id)
                    <option value="{{$id}}" @selected(request('channel_id')===$id)>{{$name}}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block" for="date">Dátum</label>
                <select name="date" id="date" placeholder="Nap" class="px-3 py-2 border border-gray-500">
                    @foreach($activeDates as $date)
                    <option value="{{$date}}" @selected(request('date')===$date)>{{$date}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </form>
</div>

<ul class="divide-y-2 divide-gray-400">
    @foreach($schedules as $index => $schedule)
    <x-schedule-element :index="$index" :schedule="$schedule" />
    @endforeach
</ul>
@endsection