@extends('layouts.master')

@section('stylesheets')
  <link rel="stylesheet" href="/css/screen.css">
@endsection

@section('content')

  @isset($empty)
    <section>

    </section>
  @else
    <section class="motivate">
      <h1>This week's goals</h1>

      {{--<p> This week we'll run a {{ $scheduleData['distance_warmup']}} km session to warm up!</p>--}}
      <ul class="goals">
        <li class="goal-motivate"> Reach {{ $scheduleData['distance_goal'] }} km in 1 session</li>
        <li class="goal-motivate"> Run {{ $scheduleData['frequency_goal'] }} times this week</li>
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
  @endisset


@endsection
