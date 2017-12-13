@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/toggle.css">
@endsection

@section('content')
    @if($user->noavatar == true ||  $user->noavatar == "true" )
        <section>
            <p>Looks like you don't have a profile picture? Upload one on Strava <a href="https://www.strava.com/settings/profile" target="_blank" class="leaderboards-filter">here!</a></p>
        </section>
    @endif


    <section class="profile-top logged-user">
        <div class="medal-profile" title="Weekly medals">
            <div><img src="/img/medals/gold-medal.png" alt="" class="medal-img"><span class="medal-counter">{{'('.$user->medals1.')'}}</span><br></div>
            <div><img src="/img/medals/silver-medal.png" alt="" class="medal-img"><span class="medal-counter">{{'('.$user->medals2.')'}}</span><br></div>
            <div>
                <img src="/img/medals/bronze-medal.png" alt="" class="medal-img"><span class="medal-counter">{{'('.$user->medals3.')'}}</span><br></div>
        </div>
        <a href="/logout" class="logout leaderboards-filter">Logout</a>
        <img class="profile-big" src="{{ $user->avatar }}" alt="{{ $user->id }}">
        <h3>{{ $user->firstname . " " . $user->lastname }}</h3>
        {{ csrf_field() }}
        @if($user->notifications == false)
            <p class="info-text">Enable email notifications</p>
            <input type="checkbox" id="cb1" class="tgl tgl-light">
            <label for="cb1" class="tgl-btn"></label>
        @else
            <p class="info-text">Disable email notifications</p>
            <input type="checkbox" id="cb1" class="tgl tgl-light" checked>
            <label for="cb1" class="tgl-btn"></label>
        @endif
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

        <section class="half half-right">
            <h2>This week</h2>
            <p>Total distance: {{$userStats['distance']}} km</p>
            <p>Total time: {{$userStats['time']}} minutes</p>
            <p>Total runs: {{$userStats['total']}}</p>


        </section>





@endsection

@section('scripts')
    <script src="/js/mail.js"></script>
@endsection