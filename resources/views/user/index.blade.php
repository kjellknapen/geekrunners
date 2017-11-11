@extends('layouts.master')

@section('content')



    <section class="profile-top">
        <span class="medal-profile" title="Amount of weekly top 5's"> &#x1f3c5;<span title="Amount of weekly top 5's" class="medal-counter">{{'('.$user->medals.')'}}</span></span>
        <a href="/logout" class="logout leaderboards-filter">Logout</a>
        <img class="profile-big" src="{{ $user->avatar }}" alt="{{ $user->id }}">
        <h3>{{ $user->firstname . " " . $user->lastname }}</h3>
    </section>

        <section class="half half-left">
            <h2>This week</h2>
            <p>Total distance: {{$userStats['distance']}} km</p>
            <p>Total time: {{$userStats['time']}} minutes</p>
            <p>Total runs: {{$userStats['total']}}</p>
            <br><br><br>
            <h2>Activity</h2>
                @foreach($runs as $run)
                <div class="activity">
                    <p><strong>{{$run->km}} km</strong></p>
                    <p>{{$run->minutes}} minutes</p>
                    <p>{{$run->average_speed}} km/u on average</p>
                    <p class="time-ago">{{\Carbon\Carbon::createFromTimeStamp(strtotime($run->date))->diffForHumans()}}</p>
                </div>
                @endforeach

        </section>

        <section class="half half-right">
            <h2>Achievements</h2>
        </section>



@endsection