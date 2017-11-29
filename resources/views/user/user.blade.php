@extends('layouts.master')

@section('content')



    <section class="profile-top">
        <div class="medal-profile" title="Weekly medals">
            <div><img src="/img/medals/gold-medal.png" alt="" class="medal-img"><span class="medal-counter">{{'('.$otheruser->medals1.')'}}</span><br></div>
            <div><img src="/img/medals/silver-medal.png" alt="" class="medal-img"><span class="medal-counter">{{'('.$otheruser->medals2.')'}}</span><br></div>
            <div><img src="/img/medals/bronze-medal.png" alt="" class="medal-img"><span class="medal-counter">{{'('.$otheruser->medals3.')'}}</span><br></div>
        </div>
        <img class="profile-big" src="{{ $otheruser->avatar }}" alt="{{ $otheruser->id }}">
        <h3>{{ $otheruser->firstname . " " . $otheruser->lastname }}</h3>
    </section>

    <section class="half half-right">
        <h2>This week</h2>
        <p>Total distance: {{$userStats['distance']}} km</p>
        <p>Total time: {{$userStats['time']}} minutes</p>
        <p>Total runs: {{$userStats['total']}}</p>


    </section>

    <section class="half half-left">
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



@endsection