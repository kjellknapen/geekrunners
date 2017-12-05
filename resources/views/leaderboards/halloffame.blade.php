@extends('layouts.master')


@section('content')
<section>
    <h1>Hall of Fame</h1>
    <p class="sub-title">Here you can see the five users with the most completed weeks! </p><br><br><br>

    <div class="halloffame-winners">
    @foreach($topfive as $key => $five)
            <div class="activity halloffame">
                <div class="halloffame-info">
                    <h1>{{ $key }}</h1>
                    <a href="/user/{{$five["user"]->id}}"><h3>{{$five["user"]->firstname.' '.$five["user"]->lastname }}</h3></a>
                    <p>{{ $five["completed"] }} weeks completed</p>
                </div>
                <div class="img-halloffame">
                    <a href="/user/{{$five["user"]->id}}"><img class="profile-big" src="{{$five["user"]->avatar}}" alt="{{$five["user"]->firstname.' '.$five["user"]->lastname}}"></a>
                </div>
            </div>
    @endforeach
    </div>
</section>

@endsection