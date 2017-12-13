<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserApiController extends Controller
{
    //
    public function index(){
        try{
            $statusCode = 200;
            $response = [
                'Users'  => []
            ];

            $users = User::all();

            foreach($users as $u){

                $response['Users'][] = [
                    'firstname' => $u->firstname,
                    'lastname' => $u->lastname,
                    'email' => $u->email,
                    'avatar' => $u->avatar,
                    'noavatar' => $u->noavatar,
                    'strava_id' => $u->strava_id,
                ];
            }

        }catch (\Exception $e){
            $statusCode = 400;
            $response = $e;
        }finally{
            return response($response, $statusCode);
        }
    }

    public function findById($id){
        try{
            $statusCode = 200;
            $response = [
                'User'  => []
            ];

            $u = User::find($id);

                $response['User'][] = [
                    'firstname' => $u->firstname,
                    'lastname' => $u->lastname,
                    'email' => $u->email,
                    'avatar' => $u->avatar,
                    'noavatar' => $u->noavatar,
                    'strava_id' => $u->strava_id,
                ];

        }catch (\Exception $e){
            $statusCode = 400;
            $response = $e;
        }finally{
            return response($response, $statusCode);
        }
    }
}
