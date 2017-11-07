@extends('layouts.master')

@section('content')

<form>
  <div class="week_schedule">

  </div>
  <div class="form-group">
    <label for="week">week</label>
    <input type="number" class=".col-xs-2" name="week" id="week">
  </div>
  <div class="form-group">
    <label for="duration">Duration goal for this week?</label>
    <input type="text" class="form-control" id="duration" name="duration" placeholder="Duration goal?">
  </div>
  <div class="form-group">
    <label for="distance">Distance goal for this week?</label>
    <input type="text" class="form-control" id="distance" name="distance" placeholder="Distance goal?">
  </div>
  <div class="form-group">
    <label for="distance">Frequency goal for this week?</label>
    <input type="text" class="form-control" id="distance" name="distance" placeholder="Frequency goal?">
  </div>
  <button type="button" class="btn btn-default">Add week </button>
</form>


@endsection
