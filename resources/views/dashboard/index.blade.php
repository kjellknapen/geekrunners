@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')

    <h1>Dashboard</h1>
    @foreach($runs as $r)
        <h1>{{ $r->name }}</h1>
        <h4>{{ $r->date }}</h4>
        <p>{{ $r->km . " km" }}</p>
        <p>{{ $r->minutes . " min"  }}</p>
        <p>{{ $r->average_speed . " m/s" }}</p>
        <p>{{ $r->max_speed . " m/s" }}</p>
    @endforeach

@endsection