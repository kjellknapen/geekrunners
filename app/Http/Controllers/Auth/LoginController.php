<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Support\Facades\Auth;
use NerdRunClub\Facades\Strava;
use NerdRunClub\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return Strava::redirect();
    }

    public function tokenexchange(){
        $code = request()->code;

        $result = Strava::tokenExchange($code);
        $this->findOrCreateUser($result);
        return redirect('/dashboard');
    }

    public function findOrCreateUser($user, Request $request){
        $userID = (int)$user->athlete->id;
        User::firstOrCreate(['email' => $user->athlete->email],[
            'firstname' => $user->athlete->firstname,
            'lastname' => $user->athlete->lastname,
            'gender' => $user->athlete->sex,
            'avatar' => $user->athlete->profile,
            'strava_id' => $userID,
            'token' => $user->access_token,
        ]);

        $loginUser = User::where('strava_id', $userID)->first();
        Auth::login($loginUser, true);
        $request::retrieveActivities($loginUser);
    }
}
