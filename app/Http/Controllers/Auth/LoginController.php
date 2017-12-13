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
        // Redirect to strava to login
        return Strava::redirect();
    }

    public function tokenexchange(){
        // Save code
        $code = request()->code;

        // Send code to strava to request token en get user
        $result = Strava::tokenExchange($code);

        // Put user un function to save it
        $this->findOrCreateUser($result);

        // Redirect to /role where the user can choose his/her role
        return redirect('/role');
    }

    public function findOrCreateUser($user){
        // Make a variable for /NerdRunClub/Request trough service providers
        $request = app()->make('Request');

        $noavatar = false;
        // Get the user id from strava
        $userID = (int)$user->athlete->id;
        // Check if the user has an avatar if not assign one to him/her
        if($user->athlete->profile != "avatar/athlete/large.png" && $user->athlete->profile != "" && $user->athlete->profile != null){
            $avatar = $user->athlete->profile;
        }else{
            // Generate an avatar that always stays the same but is differnt for every user
            $avatar = "https://api.adorable.io/avatars/285/" . $user->athlete->email;
            $noavatar = true;
        }

        if($user->athlete->sex == null || $user->athlete->sex == "" || empty($user->athlete->sex)){
            $gender = "undefined";
        }else{
            $gender = $user->athlete->sex;
        }

        // Check if the user exits otherwise create it
        User::firstOrCreate(['email' => $user->athlete->email],[
            'firstname' => $user->athlete->firstname,
            'lastname' => $user->athlete->lastname,
            'gender' => $gender,
            'avatar' => $avatar,
            'noavatar' => $noavatar,
            'strava_id' => $userID,
            'token' => $user->access_token,
        ]);

        // Get the user that was just made
        $loginUser = User::where('strava_id', $userID)->first();
        // Login this user
        Auth::login($loginUser, true);
        // Get all the users activities
        $request::retrieveActivities($loginUser);
    }
}
