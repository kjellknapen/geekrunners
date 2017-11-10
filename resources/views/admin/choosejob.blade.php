@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
    <h1>Choose your job</h1>
    @isset($error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endisset
    <div>
        <form action="{{ action('AdminController@saveJob') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="radio" name="job" id="student" value="Student">
                <label for="student">Student</label>
            </div>
            <div class="form-group">
                <input type="radio" id="teacher" name="job" value="Teacher">
                <label for="teacher">Teacher</label>
            </div>
            <input type="submit" class="btn" value="Submit">
        </form>
    </div>
@endsection