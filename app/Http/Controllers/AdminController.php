<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private $user;

    public function index()
    {
      return view('admin.index');
    }

    public function setCurrentEvent(){
        return view('admin.event');
    }

    public function saveEvent(Request $request){
        if(!empty($request->input('event-name')) && !empty($request->input('event-date')) && !empty($request->input('location'))) {
            Event::updateOrCreate(['id' => 1],[
                'name' => $request->input('event-name'),
                'event_date' => $request->input('event-date'),
                'location' => $request->input('location')
            ]);
            return view('admin.event', ['saved' => true]);
        }
        return view('admin.event', ['saved' => false]);
    }
}
