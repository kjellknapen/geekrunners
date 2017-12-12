@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')

  @isset($saved)
  @if($saved == "check")
    <p class="event-succes">The event has been updated!</p>
  @elseif($saved == "empty")
      <p class="event-fail">Fill in all the fields!</p>
  @elseif($saved == "past")
      <p class="event-fail">You can't train for something that's already over by then!</p>
  @else
    <p class="event-fail">Something went wrong, try again!</p>
  @endif
  @endisset
  <h1 class="admin-title">Set Event</h1>
  <form class="admin-form" action="{{ action('AdminController@saveEvent') }}" method="post">
    {{ csrf_field() }}

    <div class="form-group">
      <label for="event-name">Event name</label>
      <input type="text" class="form-control" name="event-name" id="event-name" placeholder="Event name" value="{{ !empty($event) ? $event->name : "" }}">
    </div>
    <div class="form-group">
      <label for="event-date">Event date</label>
      <input type="date" class="form-control" id="event-date" name="event-date" value="{{ !empty($event) ? $event->event_date : "" }}">
    </div>
    <div class="form-group">
      <label for="start-date">The date we start training</label>
      <input type="date" class="form-control" id="start-date" name="start-date" value="{{ !empty($event) ? $event->start_date : "" }}">
    </div>
    <div class="form-group">
        <label for="distance">Distance we're training for (km)</label>
        <input type="number" class="form-control" id="distance" name="distance" value="{{ !empty($event) ? $event->distance : "" }}">
    </div>
    <div class="form-group">
      <label for="location">Location</label>
      <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{ !empty($event) ? $event->location : "" }}">
    </div>
    <input type="submit" class="btn btn-default" value="Set Event">
  </form>
  <br>
  <hr>

  <h1 class="admin-title">Set Winners</h1>
  <form class="admin-form" action="{{ action('AdminController@saveEvent') }}" method="post">
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

<h1 class="admin-title">Goals</h1>
<div class="current_shedule">
  <div class="shedule-week schedule-head">
    <p class="shedule-part col-xs-1">Week</p>
    <p class="shedule-part col-xs-2">Duration (total)</p>
    <p class="shedule-part col-xs-3">Distance (warm up)</p>
    <p class="shedule-part col-xs-3">Distance (goal)</p>
    <p class="shedule-part col-xs-3">Frequency goal</p>
  </div>
  @foreach($shedules as $shedule)
    @if($shedule['week']%3 == 1)
      <section class="set">
    @endif
    <div class="shedule-week">
      <p class="shedule-part col-xs-1">{{$shedule['week']}}</p>
      <p class="shedule-part col-xs-2">{{$shedule['duration_goal']}} minutes</p>
      <p class="shedule-part col-xs-3">{{$shedule['distance_warmup']}} km</p>
      <p class="shedule-part col-xs-3">{{$shedule['distance_goal']}} km</p>
      <p class="shedule-part col-xs-3">{{$shedule['frequency_goal']}} times this week</p>
    </div>
    @if($shedule['week']%3 == 0)
  </section>
    @endif
  @endforeach
</div>


@endsection
