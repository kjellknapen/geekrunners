@extends('layouts.hall')


@section('content')
    <section>
        <h1>Hall of Fame</h1>
        <p class="sub-title">Here you can see the three users with the most completed weeks! </p><br><br><br>


        @if($eventisset == null || !isset($eventisset) || $eventisset == "" || \App\User::count()<3)
            <p class="emptystate-error">Not enough participants yet!</p>

        @else
            <div class="halloffame-winners">
                @foreach($topthree as $key => $three)
                    <div class="halloffame placed-{{$three["place"]}}">

                        <div class="img-halloffame">
                            <a href="/user/{{$three["user"]->id}}"><img class="profile-big" src="{{$three["user"]->avatar}}" alt="{{$three["user"]->firstname.' '.$three["user"]->lastname}}"></a>
                        </div>
                        <div class="halloffame-info">
                            <a href="/user/{{$three["user"]->id}}"><h3>{{$three["user"]->firstname.' '.$three["user"]->lastname }}</h3></a>
                            <p>{{ $three["completed"] }} completed</p>
                        </div>
                    </div>
                @endforeach
                <img src="/img/stage-01.png" class="hall-stage" alt="stage">
            </div>
        @endif



    </section>

@endsection