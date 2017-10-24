@extends('layouts.master')


@section('content')
    <h1>Achievements</h1>

    <h2>Done:</h2>
    <ul>
        @foreach ($achievements as $achievement)
            <div>
                <li><a href="#">{{$achievement->achievement}}</a></li>
            </div>
        @endforeach
    </ul>






@endsection