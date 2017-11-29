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
        return redirect('/role');
    }

    public function findOrCreateUser($user){
        $request = app()->make('Request');
        $userID = (int)$user->athlete->id;
        if($user->athlete->profile != "avatar/athlete/large.png" && $user->athlete->profile != "" && $user->athlete->profile != null){
            $avatar = $user->athlete->profile;
        }else{
            $avatar = "https://api.adorable.io/avatars/285/" . $user->athlete->email;
        }
        User::firstOrCreate(['email' => $user->athlete->email],[
            'firstname' => $user->athlete->firstname,
            'lastname' => $user->athlete->lastname,
            'gender' => $user->athlete->sex,
            'avatar' => $avatar,
            'strava_id' => $userID,
            'token' => $user->access_token,
        ]);

        $loginUser = User::where('strava_id', $userID)->first();
        Auth::login($loginUser, true);
        $request::retrieveActivities($loginUser);
    }
}
