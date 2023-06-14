<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashBoardController extends Controller
{


  public function index(){

        return view('dashboard');
    }
}
