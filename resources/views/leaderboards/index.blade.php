@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')

    <h1>Leaderboards</h1>

    @foreach($km as $key =>  $r)
        <div id="km" style="width:100%; text-align: left; display: flex; flex-direction: row; justify-content: space-between;">
            <p>{{ $key+1 }}</p>
            <p>{{ $r['user']->firstname . ' ' . $r['user']->lastname }}</p>
            <p>{{ $r['km'] . " km"}}</p>
        </div>
        <hr>
    @endforeach

@endsection