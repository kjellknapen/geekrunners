@extends('layouts.master')


@section('content')

    <section>
    <h1>Leaderboard</h1>
        <p class="sub-title"> Weekly nerd ranking! </p>
        <select class="leaderboards-filter" name="leaderboardfilter" id="filter">
            <option value="Km">Total distance</option>
            <option value="Time">Total time</option>
        </select>


    <div class="leaderboards-data leaderboards-data--head">
        <p>Nr.</p>
        <p>Nerd</p>
        <p>Performance</p>
    </div>
    <div id="Km" class="leaderboard">
    @foreach($leaderboard['Kilometers'] as $key =>  $r)
        <div id="km-item" class="leaderboards-data">
            <p>{{ $key+1 }}</p>
            <p class="leaderboards-data--nerd">{{ $r['user']->firstname . ' ' . $r['user']->lastname
            }}
                @if($r['user']->medals>0)

                    &#x1f3c5;<span class="medal-counter">{{'('.$r['user']->medals.')'}}</span>

                @endif

            </p>
            <p>{{ $r['km'] . " km"}}</p>
        </div>
        <hr>
    @endforeach
    </div>

    <div id="Time" class="leaderboard">
    @foreach($leaderboard['Time'] as $key =>  $r)
        <div id="time-item" class="leaderboards-data">
            <p>{{ $key+1 }}</p>
            <p class="leaderboards-data--nerd">{{ $r['user']->firstname . ' ' . $r['user']->lastname }}</p>
            <p>{{ $r['time'] . " minutes"}}</p>
        </div>
        <hr>
    @endforeach
    </div>
@endsection

    </section>

@section('scripts')
    <script src="/js/leaderboardsfilter.js"></script>
@endsection