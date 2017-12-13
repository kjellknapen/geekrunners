@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/admin.css">
@endsection

@section('content')

<h2>Looking to update something?</h2>
<div class="navbar">
  <a href="./admin/event" class="btn btn-default btn-lg">Event info</a>
  <a href="./admin/password" class="btn btn-default btn-lg">Admin password</a>
  <a href="./admin/winners" class="btn btn-default btn-lg">Declare top three</a>
</div>
<hr>

  <h1 class="admin-title">Current event info</h1>
  <section>
    <p class="shedule-part" >Name of the event: {{$event['name']}}</p>
    <p class="shedule-part" >Date of the event: {{$event['event_date']}}</p>
    <p class="shedule-part" >Date we start training: {{$event['start_date']}}</p>
    <p class="shedule-part" >Distance of the event: {{$event['distance']}}</p>
    <p class="shedule-part" >Location of the event: {{$event['location']}}</p>

  </section>

<hr>

  <h1 class="admin-title">Schedule for the current event</h1>
  <div class="current_shedule">
    <div class="shedule-week schedule-head">
      <p class="shedule-part col-xs-1">Week</p>
      <p class="shedule-part col-xs-2">Average duration</p>
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
      <p class="shedule-part col-xs-2">{{$shedule['avg_duration']}} minutes</p>
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
