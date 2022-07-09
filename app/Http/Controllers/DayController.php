<?php

namespace App\Http\Controllers;

use App\Models\Day;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DayController extends Controller
{
    //
    public function index(){
        $days = Day::orderBy('id', 'DESC')->get();
        return view('pages/day/index')
        ->with('days', $days);
    }

    public function create(Request $request){

        $fields = $request->validate([
            'name' => 'required|string',
            'image' => 'required|file',
            'description' => 'required|string'
        ]);

        if ($this->checkDayName($fields['name'])) {

            try {
                //code...
                $imageFullName = $request->file('image')->getClientOriginalName();
                $fileName = strtotime(Carbon::now()) . $imageFullName;
                $fields['image'] = $fileName;

                try {

                    Day::create($fields);

                    $request->file('image')->storeAs('public/days', $fileName);

                    return redirect()->back()->with('success', 'Day registration successful');
                } catch (\Throwable $th) {
                    //throw $th;
                    return redirect()->back()->with('error', $th->getMessage());
                }
            } catch (\Throwable $th) {
                //throw $th;
                return redirect()->back()->with('error', $th->getMessage());
            }
        } else {
            return redirect()->back()->with('error', "this name has already been used");
        }
    }


    public function checkDayName($name)
    {
        if (Day::where('name', $name)->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
