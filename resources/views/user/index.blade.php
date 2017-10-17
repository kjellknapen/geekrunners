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

@endsection