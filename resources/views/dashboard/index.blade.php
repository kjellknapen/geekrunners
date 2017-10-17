@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')

    <h1>Dashboard</h1>
    <br>

    <div class="panel panel-default" style="text-align: center;">
        <h2>{{ $userStats['daysLeft'] }} days</h2>
        <p>left until the marathon</p>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                 aria-valuemin="0" aria-valuemax="100" style="width:{{ (200 - $userStats['daysLeft']) / 200 * 100 }}%">
                {{ ceil((200 - $userStats['daysLeft']) / 200 * 100) }}%
            </div>
        </div>
    </div>
    <div class="panel panel-default"style="text-align: center;">
        <h2>Run {{ $userStats['weeklyGoal']  }} km</h2>
        <p>your weekly goal. {{ $userStats['remaining']  }} km remaining</p>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="70"
                 aria-valuemin="0" aria-valuemax="100" style="width:{{ ceil($userStats['weeklyDone'] / $userStats['weeklyGoal'] * 100) }}%">
                {{ ceil($userStats['weeklyDone'] / $userStats['weeklyGoal'] * 100) }}%
            </div>
        </div>
    </div>
    <br>
    <div class="panel panel-default"style="text-align: center;">
        <h2>Weekly top runners</h2>

    @foreach( $topRunners as $runner)

            <img style="max-width: 80px" src="{{ $runner['user']['avatar'] }}" alt="">
            <h4>{{ $runner['user']['firstname'] }}</h4>
            <h5>{{ $runner['km'] }} km</h5>
            <br>
        @endforeach
    </div>

@endsection