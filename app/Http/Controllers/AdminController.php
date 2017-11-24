<?php

namespace App\Http\Controllers;

use App\AdminPassword;
use App\Event;
use App\Schedules;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use NerdRunClub\Calculation;

class AdminController extends Controller
{
    private $user;

    public function index()
    {
      $shedules = schedules::all();
      $event = Event::find(1);
      return view('admin.index', ['shedules' => $shedules, 'event' => $event]);
    }

    public function setCurrentEvent(){
        $event = Event::find(1);
        return view('admin.event', ['event' => $event]);
    }

    public function saveEvent(Request $request, Calculation $calculation){
        $shedules = schedules::all();
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
            return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => true]);
        }
        $event = Event::find(1);
        return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => false]);
    }

    public function chooseRole(){
        return view('admin.chooserole');
    }

    public function saveRole(Request $request){
        if(!empty($request->input('role'))) {
            if($request->input('role') == "Teacher"){
                if(!empty($request->input('password'))){
                    $hashed = AdminPassword::find(1)->password;
                    if(Hash::check($request->input('password'), $hashed)){
                        User::where('id', Auth::id())->update([
                            'role' => 'Teacher'
                        ]);
                        return redirect('/dashboard');
                    }else{
                        return view('admin.chooserole', ['error' => "Wrong Password"]);
                    }
                }else{
                    return view('admin.chooserole', ['error' => "Password can't be empty"]);
                }
            }else{
                User::where('id', Auth::id())->update([
                    'role' => $request->input('role')
                ]);
            }
            return redirect('/dashboard');
        }elseif(empty($request->input('password')) && empty($request->input('role'))){
            return view('admin.chooserole', ['error' => "You didn't select anything"]);
        }else{
            return view('admin.chooserole', ['error' => "Hmm something went wrong"]);
        }
    }
}
