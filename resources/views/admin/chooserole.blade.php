@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
    <h1>I am a</h1>
    @isset($error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endisset
    <div>
        <form action="{{ action('AdminController@saveRole') }}" method="post">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="radio" name="role" id="student" value="Student">
                <label for="student">Student</label>
            </div>
            <div class="form-group">
                <input type="radio" id="teacher" name="role" value="Teacher">
                <label for="teacher">Teacher</label>
            </div>
            <input type="submit" class="btn" value="Submit">
        </form>
    </div>
@endsection