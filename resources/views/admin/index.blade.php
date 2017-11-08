@extends('layouts.master')

@section('content')

<form action="{{ action('AdminController@saveshedule') }}" method="post">
  {{ csrf_field() }}
  <div class="form-group col-xs-3">
    <label for="week">week</label>
    <input type="number" class="form-control" name="week" id="week" placeholder="Week number?">
  </div>
  <div class="form-group col-xs-3">
    <label for="duration">Duration goal for this week?</label>
    <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration goal?">
  </div>
  <div class="form-group col-xs-3">
    <label for="distance">Distance goal for this week?</label>
    <input type="number" class="form-control" id="distance" name="distance" placeholder="Distance goal?">
  </div>
  <div class="form-group col-xs-3">
    <label for="distance">Frequency goal for this week?</label>
    <input type="number" class="form-control" id="frequency" name="frequency" placeholder="Frequency goal?">
  </div>
  <input type="submit" class="btn btn-default" value="add week"> </button>
</form>

<div class="current_shedule">
  @foreach($shedules as $shedule)
    <div class="shedule-week">
      <p class="shedule-part col-xs-3">{{$shedule['week']}}</p>
      <p class="shedule-part col-xs-3">{{$shedule['duration_goal']}} minutes</p>
      <p class="shedule-part col-xs-3">{{$shedule['distance_goal']}} km</p>
      <p class="shedule-part col-xs-3">{{$shedule['frequency_goal']}} times this week</p>
    </div>
  @endforeach
</div>


@endsection
