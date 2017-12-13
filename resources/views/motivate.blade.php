@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/screen.css">
@endsection

@section('content')
  @isset($empty)
    <section>
      <p class="emptystate-error">The event hasn't started yet!</p>
    </section>
  @else
    <div class="motivate-logo">
      <img class="glasses" src="img/motivation/glasses.png" alt="logo-glasses">
      <img class="sweat" src="img/motivation/sweat.png" alt="logo-sweat">
    </div>
    <section class="motivate">
      <h1>This week's goals</h1>

      {{--<p> This week we'll run a {{ $scheduleData['distance_warmup']}} km session to warm up!</p>--}}
      <ul class="goals">
        <li class="goal-motivate">&#8594; Reach {{ $scheduleData['distance_goal'] }} km in 1 session</li>
        <li class="goal-motivate">&#8594; Run {{ $scheduleData['frequency_goal'] }} times this week</li>
      </ul>
      {{--<p class="time-ago tip">Tip: if you can run your warm-up and goal in under {{ $scheduleData['avg_duration'] }} minutes, you're right on track!</p>--}}
      <div class="completed-users">
        <p>{{ count($scheduleData['users_completed']) }} completed this</p>
        <ul class="ul-users">
          @foreach($scheduleData['users_completed'] as $key => $cuser)
              <a href="/user/{{$cuser->id}}"><li class="img-completed tooltip" title="{{$cuser->firstname  . ' '  . $cuser->lastname}}"><img src="{{ $cuser->avatar }}" alt="{{$cuser->firstname  . ' '  . $cuser->lastname }}"></li></a>
          @endforeach
        </ul>
      </div>
      <a class="motivate-link" href="https://geekrunners.weareimd.be/">Join us @ <span>geekrunners.weareimd.be</span></a>

    </section>
  @endisset


@endsection
@section('scripts')
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/js/tooltipster.bundle.min.js"></script>
  <script src="/js/dashboard.js"></script>
@endsection