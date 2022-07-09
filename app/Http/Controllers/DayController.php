<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DayController extends Controller
{
    //
    public function index(){
        return view('pages/day/index');
    }

    public function create(Request $request){
        dd($request);
    }
}
