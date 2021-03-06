<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>GeekRunners</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"  integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4="  crossorigin="anonymous"></script>

  <link href="https://fonts.googleapis.com/css?family=Roboto+Slab" rel="stylesheet">

  <link rel="shortcut icon" type="image/png" href="/img/favicon-01.png"/>

  <link rel="stylesheet" href="/css/reset.css">
  <link rel="stylesheet" href="/css/screen.css">
  <link rel="stylesheet" href="/css/leaderboards.css">
  <link rel="stylesheet" href="/css/user.css">
  <link rel="stylesheet" href="/css/admin.css">
  <link rel="stylesheet" href="/css/splash.css">
  <link rel="stylesheet" href="/css/motivate.css">
  <link rel="stylesheet" href="/css/tooltipster.bundle.min.css">
  @yield('stylesheets')

</head>
<body>
<div class="motivate-content">
  <div>
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
          <li class="goal-motivate">&#8594; <span id="distance">Reach {{ $scheduleData['distance_goal'] }} km in 1 session</span></li>
          <li class="goal-motivate">&#8594; <span id="frequency">Run {{ $scheduleData['frequency_goal'] }} times this week</span></li>
        </ul>
        {{--<p class="time-ago tip">Tip: if you can run your warm-up and goal in under {{ $scheduleData['avg_duration'] }} minutes, you're right on track!</p>--}}
        <div class="completed-users">
          <p id="amount-completed">{{ count($scheduleData['users_completed']) }} completed this</p>
          <ul class="ul-users">
            @foreach($scheduleData['users_completed'] as $key => $cuser)
              <a href="/user/{{$cuser->id}}"><li class="img-completed tooltip" title="{{$cuser->firstname  . ' '  . $cuser->lastname}}"><img src="{{ $cuser->avatar }}" alt="{{$cuser->firstname  . ' '  . $cuser->lastname }}"></li></a>
            @endforeach
          </ul>
        </div>
        <a class="motivate-link" href="https://geekrunners.weareimd.be/">Join us @ <span>geekrunners.weareimd.be</span></a>

      </section>
  </div>
</div>
@endisset
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="/js/tooltipster.bundle.min.js"></script>
<script src="/js/motivatecall.js"></script>
<script src="/js/dashboard.js"></script>
</html>