@extends('layouts.master')

@section('content')


    @isset($event)
        <section class="half half-left">
            <h1>Weekly goals</h1>
            <p class="sub-title"> We're at week {{ $scheduleData['week'] }} now </p>
            <ul class="goals">
                <li>&#10007; Reach {{ $scheduleData['distance_goal'] }} km in 1 session</li>
                <li>&#10007; Run {{ $scheduleData['frequency_goal'] }} times this week</li>
                <li>&#10007; Run atleast {{ $scheduleData['duration_goal'] }} minutes at your own pace</li>
            </ul>
        </section>

        <section class="half half-right">
            <h1>{{ $event }} days</h1>
            <p class="sub-title">Left until '{{$eventName[0]}}'</p>
            <div style="background: linear-gradient(to right, #ff9a95 {{ ceil((200 - $event) / 200 * 100) }}%,white {{ ceil((200 - $event) / 200 * 100) }}%);" class='percentageFill'></div>
        </section>
    @endisset

    <section>
        <h1>Activity feed</h1>
        <p class="sub-title">Recent runs from your fellow nerds</p><br><br><br>
        @foreach($activityfeed as $activity)
            <div class="activity">
                <p><strong>{{$activity->km}} km</strong></p>
                <p>{{$activity->minutes}} minutes</p>
                <p>{{$activity->average_speed}} km/u on average</p>
                <p class="time-ago">{{\Carbon\Carbon::createFromTimeStamp(strtotime($activity->date))->diffForHumans()}}</p>
                <div class="activity-user-info">
                    <p>{{$activity->user['firstname']}}</p>
                    <div class="img-container">
                    <img src="{{$activity->user['avatar']}}" alt="{{$activity->user['firstname'].' '.$activity->user['lastname']}}">
                    </div>
                </div>
            </div>
        @endforeach
    </section>

@endsection
