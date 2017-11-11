@extends('layouts.master')

@section('stylesheets')
    <link rel="stylesheet" href="/css/progressbar.css">
@endsection

@section('content')


    @isset($event)
        <section class="half half-left">
            <h1>Weekly goals</h1>
            <p class="sub-title"> We're at week {{ $scheduleData['week'] }} now </p>
            <ul class="goals">
                @if($scheduleData['distance_completed'] >= 100)
                    <li class="goal-completed">&#10003; Reach {{ $scheduleData['distance_goal'] }} km in 1 session.</li>
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
                    <li class="goal-completed">&#10003; Run {{ $scheduleData['frequency_goal'] }} times this week.</li>
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
                @if($scheduleData['duration_completed'] >= 100)
                    <li class="goal-completed">&#10003; Run atleast {{ $scheduleData['duration_goal'] }} minutes at your own pace</li>
                @elseif($scheduleData['duration_completed'] <= 0)
                    <li>&#10007; Run atleast {{ $scheduleData['duration_goal'] }} minutes at your own pace</li>
                @else
                    <li>
                        <div class="radial-progress" data-progress="{{ $scheduleData['duration_completed'] }}">
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
                        <p>Run atleast {{ $scheduleData['duration_goal'] }} minutes at your own pace</p>
                    </li>
                @endif
            </ul>
            <div class="completed-users">
                <p>{{ count($scheduleData['users_completed']) }} others completed this</p>
                <ul class="ul-users">
                @foreach($scheduleData['users_completed'] as $key => $cuser)
                    @if($key <= 9)
                        <li class="img-completed"><img src="{{ $cuser->avatar }}" alt="{{$cuser->firstname  . ' '  . $cuser->lastname }}"></li>
                    @elseif($key == 10)
                        <li class="img-completed"><img src="/img/Other-users-icon.png" alt="{{$cuser->firstname  . ' '  . $cuser->lastname }}"></li>
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
    @endisset

    <section>
        <h1>Activity feed</h1>
        <p class="sub-title">Recent runs from your fellow nerds</p><br><br><br>
        @foreach($activityfeed as $activity)
            <div class="activity">
                <p><strong>{{$activity->km}} km</strong></p>
                <p>{{$activity->minutes}} minutes</p>
                <p>{{$activity->average_speed}} km/u on average</p>
                <p class="time-ago">{{\Carbon\Carbon::createFromTimeStamp(strtotime($activity->date))->diffForHumans()}}</p>
                <div class="activity-user-info">
                    <p>{{$activity->user['firstname']}}</p>
                    <div class="img-container">
                    <img src="{{$activity->user['avatar']}}" alt="{{$activity->user['firstname'].' '.$activity->user['lastname']}}">
                    </div>
                </div>
            </div>
        @endforeach
    </section>

@endsection
