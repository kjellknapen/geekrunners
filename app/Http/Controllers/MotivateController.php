<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MotivateController extends Controller
{

    public function index() {
      return view('motivate');
    }

}
