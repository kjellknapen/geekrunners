<?php

namespace App\Http\Controllers;

use App\AdminPassword;
use App\Event;
use App\EventWinners;
use App\Schedules;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use NerdRunClub\Calculation;
use NerdRunClub\ScheduleCalculations;

class AdminController extends Controller
{
    private $user;

    public function index()
    {
        // Show all schedules on the admin page
        $shedules = schedules::all();

        // Get the current event
        $event = Event::find(1);

        // Get all users
        $users = User::all()->sortBy('firstname');

        // Show the index
        return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'allusers' => $users]);
    }

    // Set or Change event
    public function saveEvent(Request $request, Calculation $calculation){
        // Get all schedules to load page afterwords
        $shedules = schedules::all();
        $users = User::all()->sortBy('firstname');

        if(!empty($request->input('setwinners'))){
            EventWinners::updateOrCreate(['id' => 1],
                [
                    'user_id' => $request->input('first_place')
                ]);
            EventWinners::updateOrCreate(['id' => 2],
                [
                    'user_id' => $request->input('second_place')
                ]);
            EventWinners::updateOrCreate(['id' => 3],
                [
                    'user_id' => $request->input('third_place')
                ]);
        }else {
            // Check that nothing is empty
            if (!empty($request->input('event-name')) && !empty($request->input('event-date')) && !empty($request->input('start-date')) && !empty($request->input('location'))) {
                //can't be training for an event in the past
                if ($request->input('start-date') < $request->input('event-date')) {
                    // Check if an event already exists, update if so, create otherwise
                    Event::updateOrCreate(['id' => 1], [
                        'name' => $request->input('event-name'),
                        'event_date' => $request->input('event-date'),
                        'start_date' => $request->input('start-date'),
                        'distance' => $request->input('distance'),
                        'location' => $request->input('location')
                    ]);

                    // Find the newly set event
                    $event = Event::find(1);
                    // Set enddate of event in calculations class
                    $calculation->setEndDate();
                    // Set Startdate of event in calculations class
                    $calculation->setStartDate();
                    $calc = new ScheduleCalculations();
                    schedules::truncate();
                    $calc->create_schedule();
                    $shedules = schedules::all();
                    return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => "check", 'allusers' => $users]);
                } else {
                    $event = Event::find(1);
                    return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => "past", 'allusers' => $users]);
                }
            }
            $event = Event::find(1);
            return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'saved' => "empty", 'allusers' => $users]);
        }
        $event = Event::find(1);
        $first = EventWinners::find(1);
        $second = EventWinners::find(2);
        $third = EventWinners::find(3);
        return view('admin.index', ['shedules' => $shedules, 'event' => $event, 'allusers' => $users, 'first' => $first, 'second' => $second, 'third' => $third]);
    }

    // Load the page to choose your role
    public function chooseRole(){

        $hashedpass = \Illuminate\Support\Facades\Hash::make('WeAreIMD', [
            'rounds' => 12
        ]);
        AdminPassword::firstOrCreate([
            'password' => $hashedpass
        ]);
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
                        // Give Error of wrong pass
                        return view('admin.chooserole', ['error' => "Wrong Password"]);
                    }
                }else{
                    // Give error of empty pass
                    return view('admin.chooserole', ['error' => "Password can't be empty"]);
                }
            }else{
                // Save users role as student
                User::where('id', Auth::id())->update([
                    'role' => $request->input('role')
                ]);
            }
            return redirect('/dashboard');
        }elseif(empty($request->input('password')) && empty($request->input('role'))){
            // Error for not selecting anything
            return view('admin.chooserole', ['error' => "You didn't select anything"]);
        }else{
            // Error if something else was wrong
            return view('admin.chooserole', ['error' => "Hmm something went wrong"]);
        }
    }


}
