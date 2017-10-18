<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Achievements extends Controller
{
    public function index()
    {
        $achievements = DB::table('achievements')->get();

        return view('achievements.index',
            [
                'achievements' => $achievements,
            ]
        );
    }
}
