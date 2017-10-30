<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Calculation;

class AdminController extends Controller
{
    private $user;

    public function index()
    {
      return view('admin.index');
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
