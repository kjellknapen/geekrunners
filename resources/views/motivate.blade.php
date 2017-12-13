@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/screen.css">
@endsection

@section('content')

  <section class="motivate">
    <h1>This week's goals</h1>

      {{--<p> This week we'll run a {{ $scheduleData['distance_warmup']}} km session to warm up!</p>--}}
      <ul class="goals">
        @if($scheduleData['distance_completed'] >= 100)
          <li class="goal-completed">&#10003; Reach {{ $scheduleData['distance_goal'] }} km in 1 session</li>
        @elseif($scheduleData['distance_completed'] <= 0)
          <li>&#10007; Reach {{ $scheduleData['distance_goal'] }} km in 1 session</li>
        @else
          <li>
            <div class="radial-progress" data-progress="{{ $scheduleData['distance_completed'] }}">
              <div class="circle">
                <div class="mask full">
                  <div class="fill"></div>
                </div>
                <div class="mask half">
                  <div class="fill"></div>
                  <div class="fill fix"></div>
                </div>
              </div>
              <div class="inset"></div>
            </div>
            <p>Reach {{ $scheduleData['distance_goal'] }} km in 1 session</p>
          </li>
        @endif
        @if($scheduleData['frequency_completed'] >= 100)
          <li class="goal-completed">&#10003; Run {{ $scheduleData['frequency_goal'] }} times this week</li>
        @elseif($scheduleData['frequency_completed'] <= 0)
          <li>&#10007; Run {{ $scheduleData['frequency_goal'] }} times this week</li>
        @else
          <li>
            <div class="radial-progress" data-progress="{{ $scheduleData['frequency_completed'] }}">
              <div class="circle">
                <div class="mask full">
                  <div class="fill"></div>
                </div>
                <div class="mask half">
                  <div class="fill"></div>
                  <div class="fill fix"></div>
                </div>
              </div>
              <div class="inset"></div>
            </div>
            <p>Run {{ $scheduleData['frequency_goal'] }} times this week </p>
          </li>
        @endif

      </ul>
      {{--<p class="time-ago tip">Tip: if you can run your warm-up and goal in under {{ $scheduleData['avg_duration'] }} minutes, you're right on track!</p>--}}
      <div class="completed-users">
        <p>{{ count($scheduleData['users_completed']) }} completed this</p>
        <ul class="ul-users">
          @foreach($scheduleData['users_completed'] as $key => $cuser)
            @if($key <= 9)
              <a href="/user/{{$cuser->id}}"><li class="img-completed tooltip" title="{{$cuser->firstname  . ' '  . $cuser->lastname}}"><img src="{{ $cuser->avatar }}" alt="{{$cuser->firstname  . ' '  . $cuser->lastname }}"></li></a>
            @elseif($key == 10)
              <a href="/user/{{$cuser->id}}"><li class="img-completed"><img src="/img/Other-users-icon.png" alt="{{$cuser->firstname  . ' '  . $cuser->lastname }}"></li></a>
            @endif
          @endforeach
        </ul>
      </div>

  </section>


@endsection
