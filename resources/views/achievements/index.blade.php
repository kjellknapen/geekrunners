@extends('layouts.master')


@section('content')
    @include('layouts.partials._navigation')
    <h1>Achievements</h1>

    <h2>Done:</h2>
    <ul>
        @foreach ($achievements as $achievement)
            <div>
                <li><img src="{{$achievement->img}}" alt=""><a href="#">{{$achievement->description}}</a></li>
            </div>
        @endforeach
    </ul>






@endsection