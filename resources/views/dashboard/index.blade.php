@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')

    <h1>Dashboard</h1>
    @foreach($runs as $r)
        <h1>{{ $r->name }}</h1>
        <p>{{ number_format ( $r->distance/1000, 2) . " km" }}</p>
        <p>{{ floor ($r->elapsed_time / 60) . " min"  }}</p>
        <p>{{ $r->max_speed . " m/s" }}</p>
    @endforeach

@endsection