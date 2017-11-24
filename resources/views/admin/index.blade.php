@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')

  @isset($saved)
  @if($saved)
    <p class="event-succes">The event has been updated!</p>
  @else
    <p class="event-fail">Something went wrong, try again!</p>
  @endif
  @endisset
  <h1>Set Event</h1>
  <form action="{{ action('AdminController@saveEvent') }}" method="post">
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
      <label for="location">Location</label>
      <input type="text" class="form-control" id="location" name="location" placeholder="Location" value="{{ !empty($event) ? $event->location : "" }}">
    </div>
    <input type="submit" class="btn btn-default" value="Set Event">
  </form>

  <hr>

<h1>Schedules</h1>
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
