@extends('layouts.master')

@include('layouts.partials._navigation')
@section('content')

    <img src="{{ $user->avatar }}" alt="{{ $user->id }}">
    <h1>{{ $user->firstname . " " . $user->lastname }}</h1>

    <h3>Activities</h3>

    <br>

    <div class="panel panel-default" style="text-align: center;">
        <h4>Weekly stats</h4>

        <p>Total distance xkm</p>
        <p>Longest run xkm</p>
        <p>Average speed xkm/h</p>
        <hr>
        <p>Last run xdays ago</p>

    </div>

@endsection