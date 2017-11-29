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
        // Show all schedules on the admin page
        $shedules = schedules::all();

        // Get the current event
        $event = Event::find(1);

        // Show the index
        return view('admin.index', ['shedules' => $shedules, 'event' => $event]);
    }

    // Set or Change event
    public function saveEvent(Request $request, Calculation $calculation){
        // Get all schedules to load page afterwords
        $shedules = schedules::all();

        // Check that nothing is empty
        if(!empty($request->input('event-name')) && !empty($request->input('event-date')) && !empty($request->input('start-date')) && !empty($request->input('location'))) {
            // Update if event exists otherwise create an event
            Event::updateOrCreate(['id' => 1],[
                'name' => $request->input('event-name'),
                'event_date' => $request->input('event-date'),
                'start_date' => $request->input('start-date'),
                'location' => $request->input('location')
            ]);

            // Find the newly set event
            $event = Event::find(1);
            // Set enddate of event in calculations class
            $calculation->setEndDate();
            // Set Startdate of event in calculations class
            $calculation->setStartDate();
            return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => true]);
        }
        $event = Event::find(1);
        return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => false]);
    }

    // Load the page to choose your role
    public function chooseRole(){
        return view('admin.chooserole');
    }

    // Save the role in the database
    public function saveRole(Request $request){

        // Check that role isn't empty
        if(!empty($request->input('role'))) {
            // Check if role is teacher
            if($request->input('role') == "Teacher"){
                // Check if they sent a password
                if(!empty($request->input('password'))){
                    // Get Password from database
                    $hashed = AdminPassword::find(1)->password;

                    // Check if passwords match
                    if(Hash::check($request->input('password'), $hashed)){
                        // Update user with role of teacher
                        User::where('id', Auth::id())->update([
                            'role' => 'Teacher'
                        ]);
                        return redirect('/dashboard');
                    }else{
                        // G
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
