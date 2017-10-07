<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
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
        //return Socialite::driver('strava')->redirect();
        return redirect('https://www.strava.com/oauth/authorize?client_id=20590&response_type=code&redirect_uri=http://nerdrunclub.app/token_exchange&state=mystate');
    }

    public function tokenexchange(){
        $code = request()->code;
        $client = new Client();
        //$url = "'https://www.strava.com/oauth/token?client_id=20594&client_secret=426f99ae57f2c243fdcc6e5fa320c011523c6161&code=".$code."'";
        $res = $client->request('POST', 'https://www.strava.com/oauth/token', [
            'form_params' => [
                'client_id' => '20590',
                'client_secret' => 'f547d41bb416342504f68b64aa24216544d3154d',
                'code' => $code,
            ]
        ]);

        $result= \GuzzleHttp\json_decode($res->getBody());
        $this->findOrCreateUser($result);
        return redirect('/');
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

            Auth::login($user, true);
        }
    }
}
