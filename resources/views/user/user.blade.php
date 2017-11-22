@extends('layouts.master')

@section('content')



    <section class="profile-top">
        <div class="medal-profile" title="Weekly medals">
            <div>&#129351;<span class="medal-counter">{{'('.$user->medals1.')'}}</span><br></div>
            <div>&#129352;<span class="medal-counter">{{'('.$user->medals2.')'}}</span><br></div>
            <div>
                &#129353;<span class="medal-counter">{{'('.$user->medals3.')'}}</span><br></div>
        </div>
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
        @foreach ($achievements as $achievement)
            <div class="achievements">
                <ul>
                    <li><img src="{{$achievement->img}}" alt="" width="50px" height="50px"><a href="#"></a></li>
                </ul>
            </div>
        @endforeach
    </section>



@endsection