@extends('layouts.master')

@include('layouts.partials._navigation')
@section('content')

    <form>
        <div class="form-group">
            <label for="event-name">Event name</label>
            <input type="text" class="form-control" name="event-name" id="event-name" placeholder="Event name">
        </div>
        <div class="form-group">
            <label for="event-date">Event date</label>
            <input type="date" class="form-control" id="event-date" name="event-date">
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Location">
        </div>
        <button type="button" class="btn btn-default">Set event</button>
    </form>


@endsection