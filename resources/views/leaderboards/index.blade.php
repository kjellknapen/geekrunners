@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')

    <div>
    <h1>Leaderboards</h1>
        <select name="leaderboardfilter" id="filter">
            <option value="Km">Most Km</option>
            <option value="Time">Most Time</option>
        </select>
    </div>

    <div id="Km" class="leaderboard">
    @foreach($leaderboard['Kilometers'] as $key =>  $r)
        <div id="km-item" style="width:100%; text-align: left; display: flex; flex-direction: row; justify-content: space-between;">
            <p>{{ $key+1 }}</p>
            <p>{{ $r['user']->firstname . ' ' . $r['user']->lastname }}</p>
            <p>{{ $r['km'] . " km"}}</p>
        </div>
        <hr>
    @endforeach
    </div>

    <div id="Time" class="leaderboard">
    @foreach($leaderboard['Time'] as $key =>  $r)
        <div id="time-item" style="width:100%; text-align: left; display: flex; flex-direction: row; justify-content: space-between;">
            <p>{{ $key+1 }}</p>
            <p>{{ $r['user']->firstname . ' ' . $r['user']->lastname }}</p>
            <p>{{ $r['time'] . " minutes"}}</p>
        </div>
        <hr>
    @endforeach
    </div>

    <script src="/js/leaderboardsfilter.js"></script>
@endsection