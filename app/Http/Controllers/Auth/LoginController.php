<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\StravaHandler;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

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
    protected $redirectTo = '/home';

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
        return StravaHandler::redirect();
    }

    public function tokenexchange(){
        $code = request()->code;

        $result = StravaHandler::tokenExchange($code);
        $this->findOrCreateUser($result);
        return redirect('/dashboard');
    }

    public function findOrCreateUser($user){
        $userID = (int)$user->athlete->id;
        $authUser = User::where('strava_id', $userID)->first();
        if ($authUser) {
            Auth::login($authUser, true);
            return $authUser;
        }else{
            User::create([
                'firstname' => $user->athlete->firstname,
                'lastname' => $user->athlete->lastname,
                'gender' => $user->athlete->sex,
                'email' => $user->athlete->email,
                'avatar' => $user->athlete->profile,
                'strava_id' => $userID,
                'token' => $user->access_token,
            ]);

            $loginUser = User::where('strava_id', $userID)->first();
            Auth::login($loginUser, true);
        }
    }
}
