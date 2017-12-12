@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')


  <h1 class="admin-title">Set Winners</h1>
  <form class="admin-form" action="{{ action('AdminController@saveWinners') }}" method="post">
    {{ csrf_field() }}
    <input type="hidden" name="setwinners" id="setwinners" value="true">
    <div class="form-group">
      <label for="first-place">First place</label>
      <select class="form-control" id="first-place" name="first-place">
        @foreach($allusers as $u)
          <option value="{{ $u->id }}" {{ !empty($first) && $first->user_id == $u->id ? 'selected="selected"' : '' }}>{{ $u->firstname . ' ' . $u->lastname }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="second-place">Second place</label>
      <select class="form-control" id="second-place" name="second-place">
        @foreach($allusers as $u)
          <option value="{{ $u->id }}" {{ !empty($second) && $second->user_id == $u->id ? 'selected="selected"' : '' }}>{{ $u->firstname . ' ' . $u->lastname }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="third-place">Third place</label>
      <select class="form-control" id="third-place" name="third-place">
        @foreach($allusers as $u)
          <option value="{{ $u->id }}" {{ !empty($third) && $third->user_id == $u->id ? 'selected="selected"' : '' }}>{{ $u->firstname . ' ' . $u->lastname }}</option>
        @endforeach
      </select>
    </div>
    <input type="submit" class="btn btn-default" value="Set Winners">
  </form>
  <br>
  <hr>

  @endsection
