@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')
    <h1>Fill in the password</h1>
    @isset($error)
        <p class="alert alert-danger">{{ $error }}</p>
    @endisset
    <div>
    <form action="{{ action('AdminController@saveRole') }}" method="post">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="password">Teacher's Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password">
        </div>
        <input type="submit" class="btn" value="Submit">
    </form>
    </div>
@endsection