@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/progressbar.css">
@endsection

@section('content')
    @isset($event)
      @if($D_Day == false)
        <div class="goal-tree">
            @foreach($weekTree as $key => $week)


                @if($key == $scheduleData['week'])

                    @if($key == "1")
                        @if($week == "completed")
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-start-completed.svg" alt="treestart"></span>
                        @elseif($week == "failed")
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-start-failed.svg" alt="treestart"></span>
                        @else
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-start-grey.svg" alt="treestart"></span>
                        @endif
                    @elseif($key == count($weekTree))
                        @if($week == "completed")
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-end-completed.svg" alt="treeend"></span>
                        @elseif($week == "failed")
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-end-failed.svg" alt="treeend"></span>
                        @else
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-end-grey.svg" alt="treeend"></span>
                        @endif
                    @else
                        @if($week == "completed")
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-center-completed.svg" alt="treecenter"></span>
                        @elseif($week == "failed")
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-center-failed.svg" alt="treecenter"></span>
                        @else
                            <span title="Week {{$key}}" class="tooltip currentTree normalize"><img src="img/tree-center-grey.svg" alt="treecenter"></span>
                        @endif
                    @endif


                @elseif($key == "1")
                    @if($week == "completed")
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-start-completed.svg" alt="treestart"></span>
                    @elseif($week == "failed")
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-start-failed.svg" alt="treestart"></span>
                    @else
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-start-grey.svg" alt="treestart"></span>
                    @endif
                @elseif($key == count($weekTree))
                    @if($week == "completed")
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-end-completed.svg" alt="treeend"></span>
                    @elseif($week == "failed")
                                <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-end-failed.svg" alt="treeend"></span>
                    @else
                         <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-end-grey.svg" alt="treeend"></span>
                    @endif
                @else
                    @if($week == "completed")
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-center-completed.svg" alt="treecenter"></span>
                    @elseif($week == "failed")
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-center-failed.svg" alt="treecenter"></span>
                    @else
                        <span title="Week {{$key}}" class="tooltip normalize"><img src="img/tree-center-grey.svg" alt="treecenter"></span>
                    @endif
                @endif
            @endforeach
        </div>
        <section class="half half-left">
            <h1>Weekly goals</h1>
            <p class="sub-title"> We're at week {{ $scheduleData['week'] }} now </p>
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
                <p>{{ count($scheduleData['users_completed']) }} others completed this</p>
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

        <section class="half half-right">
            <h1>{{ $event }} days</h1>
            <p class="sub-title">Left until '{{$eventName[0]}}'</p>
            <div style="background: linear-gradient(to right, #ff9a95 {{ ceil((200 - $event) / 200 * 100) }}%,white {{ ceil((200 - $event) / 200 * 100) }}%);" class='percentageFill'></div>
        </section>
        @else
        <section>
            @if($diff == 0)
                <h1>Today is D-day</h1>
            @else
                <h1>We Passed D-day</h1>
            @endif
            <p class="sub-title">We have ran for the {{ $eventName[0] }}</p><br><br><br>
            <p>The winners of this event were</p>




                <div class="halloffame-winners">
                    @foreach($topthreedday as $key => $three)
                        <div class="halloffame placed-{{ $three->id }}">

                            <div class="img-halloffame">
                                <a href="#"><img class="profile-big" src="{{$three->user->avatar}}" alt="{{$three->user->firstname.' '.$three->user->lastname}}"></a>
                            </div>
                            <div class="halloffame-info">
                                <a href="/user/{{$three->user->id}}"><h3>{{$three->user->firstname.' '.$three->user->lastname }}</h3></a>
                            </div>
                        </div>
                    @endforeach


                    <img src="/img/stage-01.png" class="hall-stage" alt="stage">
                </div>


        </section>
        @endif
    @endisset
    @isset($future)
      <section>
          <h2 class="sub-title">Have some patience, the training starts at {{$future}}</p>
      </section>
    @endisset
    @isset($noevent)
      <section>
          <h2 class="sub-title">We're not training for an event right now, but you can still compete with your friends!</p>
      </section>
    @endisset
    <section>
        <h1>Activity feed</h1>
        <p class="sub-title">Recent runs from your fellow geeks</p><br><br><br>
        <div class="activity-container">
        @foreach($activityfeed as $activity)

                <div class="activity activity--grid">
                    <p><strong>{{$activity->km}} km</strong></p>
                    <p>{{$activity->minutes}} minutes</p>
                    <p>{{$activity->average_speed}} km/u on average</p>
                    <p class="time-ago">{{\Carbon\Carbon::createFromTimeStamp(strtotime($activity->date))->diffForHumans()}}</p>
                    <div class="activity-user-info">
                        <a href="/user/{{$activity->user['id']}}"><p>{{$activity->user['firstname'] . ' ' . $activity->user['lastname']}}</p></a>
                        <div class="img-container">
                            <a href="/user/{{$activity->user['id']}}"><img src="{{$activity->user['avatar']}}" alt="{{$activity->user['firstname'].' '.$activity->user['lastname']}}"></a>
                        </div>
                    </div>
                </div>

        @endforeach
        </div>
    </section>

@endsection


@section('scripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="/js/tooltipster.bundle.min.js"></script>
    <script src="/js/dashboard.js"></script>
@endsection
