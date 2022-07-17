<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DentistSchedule;

use Auth;

class DentistScheduleContoller extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $user = Auth::user();
        return view('dentist.dentist-schedule')
            ->with('id', $user->user_id);
    }

    public function show($id){
        return DentistSchedule::find($id);
    }

    public function getDentistSchedules(){
        $id = Auth::user()->user_id;

        return DentistSchedule::where('user_id', $id)->get();
    }

    public function store(Request $req){
        $id = Auth::user()->user_id;

        $timeFrom =  $req->from_time;
        $nTimeFrom = date('H:i:s', strtotime($timeFrom)); //convert to date format UNIX

        $timeTo = $req->to_time;
        $nTimeTo = date('H:i:s',strtotime($timeTo)); //convert to format time UNIX

        $data = DentistSchedule::create([
            'user_id' => $id,
            'from' => $nTimeFrom,
            'to' => $nTimeTo,
            'mon' => $req->mon,
            'tue' => $req->tue,
            'wed' => $req->wed,
            'thur' => $req->thur,
            'fri' => $req->fri,
            'sat' => $req->sat,
            'sun' => $req->sun,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);

    }


    public function update(Request $req, $id){
        
        $data = DentistSchedule::find($id);

        $timeFrom =  $req->from_time;
        $nTimeFrom = date('H:i:s', strtotime($timeFrom)); //convert to date format UNIX

        $timeTo = $req->to_time;
        $nTimeTo = date('H:i:s',strtotime($timeTo)); //convert to format time UNIX

        $data->from = $nTimeFrom;
        $data->to = $nTimeTo;
        $data->mon = $req->mon;
        $data->tue = $req->tue;
        $data->wed = $req->wed;
        $data->thur = $req->thur;
        $data->fri = $req->fri;
        $data->sat = $req->sat;
        $data->sun = $req->sun;
        
        $data->save();

        return response()->json([
            'status' => 'updated'
        ],200);
    }

    public function destroy($id){
        
        DentistSchedule::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ],200);
    }
}
