<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetAppointmentController extends Controller
{
    //

    public function store(Request $req){

        $date =  $req->app_date;
        $ndate = date("Y-m-d", strtotime($date)); //convert to date format UNIX

        $timeFrom = $req->app_time_from;
        $timeTo = $req->app_time_to;

        $ntimeFrom = date('H:i:s',strtotime($timeFrom)); //convert to format time UNIX
        $ntimeTo = date('H:i:s',strtotime($timeTo)); //convert to format time UNIX

        $user = Auth::user();

        $n = time() . $user->lname . $user->fname;
        $refcode = substr(md5($n), -8);

        Appointment::create([
            'ref_no' => $refcode,
            'appointment_user_id' => $user->user_id,
            'training_center_id' => $req->training_center,
            'app_date' => $ndate,
            'app_time_from' => $ntimeFrom,
            'app_time_to' => $ntimeTo,
            'app_status' => 0,
            'remarks' => $req->remarks,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

}
