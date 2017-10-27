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
            <br><br>
            <h2>Activities</h2>


        </section>

        <section class="half half-right">
            <h2>Achievements</h2>
        </section>



@endsection