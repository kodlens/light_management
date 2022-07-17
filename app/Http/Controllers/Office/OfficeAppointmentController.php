<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\AppClock;
use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfficeAppointmentController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('office');
    }


    public function index(){
        return view('office.office-appointment');
    }

    public function getOfficeAppointments(Request $req){
        $sort = explode('.', $req->sort_by);
        $user = Auth::user();
        $ndate = date("Y-m-d", strtotime($req->appdate));

        $data = DB::table('appointments as a')
            ->join('appointment_types as b', 'a.appointment_type_id', 'b.appointment_type_id')
            ->join('offices as c', 'b.office_id', 'c.office_id')
            ->leftJoin('users as d', 'c.office_id', 'd.office_id')
            ->leftJoin('users as e', 'a.appointment_user_id', 'e.user_id')
            ->where('a.app_date', 'like', $ndate . '%')
            ->where('d.user_id', $user->user_id)
            ->orderBy('a.' . $sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function noOfRequest(){
        $user = Auth::user();
        $ndate = date("Y-m-d", strtotime(now()));

        $count = DB::table('appointments as a')
            ->join('appointment_types as b', 'a.appointment_type_id', 'b.appointment_type_id')
            ->where('b.office_id', $user->office_id)
            ->where('a.app_date', $ndate)
            ->count();

        return $count;
    }

    public function approveAppointment($id){
        $data = Appointment::find($id);
        $data->is_approved = 1;
        $data->save();


        return response()->json([
            'status' => 'approved'
        ],200);
    }

    public function cancelAppointment($id){
        $data = Appointment::find($id);
        $data->is_approved = 2;
        $data->save();


        return response()->json([
            'status' => 'cancelled'
        ],200);
    }

    public function updateTime(Request $req, $id){

        $req->validate([
            'app_date' => ['required'],
        ], $message = [
            'app_date.required' => 'Please select date and time.',
        ]); //validating input

        $date =  $req->app_date;
        $ndate = date("Y-m-d", strtotime($date)); //convert to date format UNIX

        $time = $req->app_time;
        $ntime = date('H:i:s',strtotime($time)); //convert to format time UNIX

        $appData = AppointmentType::where('appointment_type_id', $req->appointment_type_id)->first(); //get first the appointment type so we can get the cc_time
        $nTimeString = '+'.$appData->cc_time.' minutes'; //concat string..

        $max_multiple = $appData->max_multiple;

        $addedTime = date("H:i", strtotime($nTimeString, strtotime($time))); //time added base on the time set in appointment type

        $appClock = AppClock::where('start_time', '<=', $ntime)
            ->where('end_time', '>=', $ntime)->exists();

        if(!$appClock){
            return response()->json([
                'errors' => [
                    'not_allowed' =>  ['Booking is not allowed this time.']
                ]
            ], 422);
        }

        //labad sa ulo ang filtering conflict sa time
//        $countExist = DB::table('appointments as a')
//            ->join('appointment_types as b', 'a.appointment_type_id', 'b.appointment_type_id')
//            ->where('app_date', $ndate)
//            ->where(function($query) use ($ntime, $addedTime){
//                $query->whereBetween('app_time_from', [$ntime, $addedTime])
//                    ->orWhereBetween('app_time_to', [$ntime,$addedTime]);
//            })
//            ->where('a.appointment_type_id', $req->appointment_type_id)
//            ->where('a.appointment_id', '!=', $id)
//            ->count();

//        if($countExist >= $max_multiple){
//            return response()->json([
//                'errors' => [
//                    'limit' =>  ['Sorry, no available slot at the moment. Please select another schedule.']
//                ]
//            ], 422);
//        }


        Appointment::where('appointment_id', $id)
            ->update([
                'app_date' => $ndate,
                'app_time_from' => $ntime,
                'app_time_to' => $addedTime,
                'visit_status' => 'APPROVED' //auto approve if office will change the time and date
            ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }
}
