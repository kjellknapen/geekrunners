@extends('layouts.master')

@include('layouts.partials._navigation')
@section('content')



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
        <h1>{{ $userStats['daysLeft'] }} days</h1>
        <p class="sub-title">left until the marathon</p>
        <div style="background: linear-gradient(to right, #ff9a95 {{ ceil((200 - $userStats['daysLeft']) / 200 * 100) }}%,white {{ ceil((200 - $userStats['daysLeft']) / 200 * 100) }}%);" class='percentageFill'></div>
    </section>

    <section>
        <h1>Activity feed</h1>
        <p class="sub-title">recent activities from all users here</p>
    </section>

@endsection
