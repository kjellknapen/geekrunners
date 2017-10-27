@extends('layouts.master')

@include('layouts.partials._navigation')
@section('content')



    <section class="profile-top">
        <img class="profile-big" src="{{ $user->avatar }}" alt="{{ $user->id }}">
        <h3>{{ $user->firstname . " " . $user->lastname }}</h3>
    </section>

        <section class="half half-left">
            <h2>This week</h2>
            <p>Total distance: </p>
            <p>Total time: </p>
            <br><br><br>
            <h2>Activity</h2>
            <div class="activity">
                @foreach($runs as $run)
                    <p><strong>{{$run->km}} km</strong></p>
                    <p>{{$run->minutes}} minutes</p>
                    <p>{{$run->average_speed}} km/u on average</p>
                    <p class="time-ago">{{\Carbon\Carbon::createFromTimeStamp(strtotime($run->created_at))->diffForHumans()}}</p>

                @endforeach
            </div>

        </section>

        <section class="half half-right">
            <h2>Achievements</h2>
        </section>



@endsection