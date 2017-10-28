<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    private $user;

    public function index()
    {
      return view('admin.index');
    }

    public function setCurrentEvent(){
        return view('admin.event');
    }
}
