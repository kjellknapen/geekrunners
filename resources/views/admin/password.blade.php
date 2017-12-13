@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')

@isset($saved)
  @if($saved == "check")
    <p class="event-succes">The password has been updated!</p>
  @elseif($saved == "empty")
    <p class="event-fail">Fill in all the fields!</p>
  @else
    <p class="event-fail">Something didn't match, try again!</p>
@endif
@endisset

<h1 class="admin-title">Set password</h1>
<form class="admin-form" action="{{ action('AdminController@savePassword') }}" method="post">
  {{ csrf_field() }}

  <div class="form-group">
    <label for="current_pw">Current password</label>
    <input type="password" class="form-control" id="current_pw" name="current_pw" placeholder="current password">
  </div>
  <div class="form-group">
    <label for="new_pw">New password</label>
    <input type="password" class="form-control" id="new_pw" name="new_pw"  placeholder="New password">
  </div>
  <div class="form-group">
    <label for="repeat_pw">Repeat new password</label>
    <input type="password" class="form-control" id="repeat_pw" name="repeat_pw"  placeholder="Repeat password">
  </div>

  <input type="submit" class="btn btn-default" value="Set password">
</form>

  @endsection
