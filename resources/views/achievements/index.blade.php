@extends('layouts.master')


@section('content')
    <h1>Achievements</h1>

    <h2>Done:</h2>
    <ul>
        @foreach ($achievements as $achievement)
            <div>
                <li><img src="{{$achievement->img}}" alt="" width="100px" height="100px"><a href="#">{{$achievement->description}}</a></li>
            </div>
        @endforeach
    </ul>






@endsection