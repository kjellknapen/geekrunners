<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Achievements extends Controller
{
    public function index()
    {
        $achievementsDone = DB::table('achievements')->where('done', 1)->get();
        $achievementsTodo = DB::table('achievements')->where('done', 0)->get();

        return view('achievements.index',
            [
                'achievementsDone' => $achievementsDone,
                'achievementsTodo' => $achievementsTodo
            ]
        );
    }
}
