<?php

namespace App\Http\Controllers;

use App\Event;
use App\Schedules;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Calculation;

class AdminController extends Controller
{
    private $user;

    public function index()
    {
      $shedules = schedules::all();
      return view('admin.index', ['shedules' => $shedules]);
    }

    public function saveshedule(Request $request){
      if(!empty($request->input('week')) && !empty($request->input('duration')) &&  !empty($request->input('distance')) &&  !empty($request->input('frequency'))) {
          schedules::create(
           ['week' => $request->input('week'),
            'duration_goal' => $request->input('duration'),
            'distance_goal' => $request->input('distance'),
            'frequency_goal'=> $request->input('frequency')
          ]);
          $shedules = schedules::all();
          return view('admin.index', ['shedules' => $shedules]);
      }
      $shedules = schedules::all();
      return view('admin.index', ['shedules' => $shedules]);
    }


    public function setCurrentEvent(){
        $event = Event::find(1);
        return view('admin.event', ['event' => $event]);
    }

    public function saveEvent(Request $request, Calculation $calculation){
        if(!empty($request->input('event-name')) && !empty($request->input('event-date')) && !empty($request->input('start-date')) && !empty($request->input('location'))) {
            Event::updateOrCreate(['id' => 1],[
                'name' => $request->input('event-name'),
                'event_date' => $request->input('event-date'),
                'start_date' => $request->input('start-date'),
                'location' => $request->input('location')
            ]);
            $event = Event::find(1);
            $calculation->setEndDate();
            $calculation->setStartDate();
            return view('admin.event', ['event' => $event, 'saved' => true]);
        }
        $event = Event::find(1);
        return view('admin.event', ['event' => $event, 'saved' => false]);
    }
}
