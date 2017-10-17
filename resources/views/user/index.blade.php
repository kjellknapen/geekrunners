@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')

    <h1>Profile</h1>
    <img src="{{ $user->avatar }}" alt="{{ $user->id }}">
    <p>{{ $user->firstname . " " . $user->lastname }}</p>
    @if($user->gender == "" || $user->gender == null)
    @elseif($user->gender == "M")
        <p>Male</p>
    @else
        <p>Female</p>
    @endif
    <p>{{ $user->email }}</p>

    <h2>Activities</h2>

    @foreach($runs as $r)
        <div class="panel panel-default">
    <h3>{{ $r->name }}</h3>
    <h4>{{ $r->date }}</h4>
    <p>{{ $r->km . " km" }}</p>
    <p>{{ $r->minutes . " min"  }}</p>
    <p>{{ $r->average_speed . " m/s" }}</p>
    <p>{{ $r->max_speed . " m/s" }}</p>
        </div>
    @endforeach

@endsection