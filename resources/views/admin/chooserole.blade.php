@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
    <section class="half half-left">
    <h1>I am a</h1>
        <br>
    @isset($error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endisset
        <br>
    <div>
        <form action="{{ action('AdminController@saveRole') }}" method="post" class="role-form">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="radio" name="role" id="student" value="Student">
                <label for="student">Student</label>
            </div>
            <div class="form-group">
                <input type="radio" id="teacher" name="role" value="Teacher">
                <label for="teacher">Teacher</label>
            </div>
            <div class="form-group password-field">
                <label for="password">Teacher's Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
            </div>
            <input type="submit" class="btn btn-lg geek-button" value="Submit">
        </form>
    </div>
    </section>
@endsection

@section('scripts')
    <script src="/js/password.js"></script>
@endsection