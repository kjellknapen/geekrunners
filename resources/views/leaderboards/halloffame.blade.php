@extends('layouts.hall')


@section('content')
    <section>
        <h1>Hall of Fame</h1>
        <p class="sub-title">Here you can see the five users with the most completed weeks! </p><br><br><br>

        <div class="halloffame-winners">
        @foreach($topthree as $key => $three)
                <div class="activity halloffame">
                    <div class="halloffame-info">
                        <h1>{{ $key }}</h1>
                        <a href="/user/{{$three["user"]->id}}"><h3>{{$three["user"]->firstname.' '.$three["user"]->lastname }}</h3></a>
                        <p>{{ $three["completed"] }} weeks completed</p>
                    </div>
                    <div class="img-halloffame">
                        <a href="/user/{{$three["user"]->id}}"><img class="profile-big" src="{{$three["user"]->avatar}}" alt="{{$three["user"]->firstname.' '.$three["user"]->lastname}}"></a>
                    </div>
                </div>
        @endforeach
        </div>
    </section>

@endsection