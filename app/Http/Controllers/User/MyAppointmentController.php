<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\AppClock;
use App\Models\Appointment;
use App\Models\AppointmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class MyAppointmentController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index(){
        return view('user.my-appointment');
    }

    public function getMyAppointment(Request $req){
        $user =  Auth::user();

        $sort = explode('.', $req->sort_by);

        $date = $req->appdate;
        //$ndate = date('Y-m-d',strtotime($date)); //convert to format time UNIX

        if($req->appdate){
            $ndate = date("Y-m-d", strtotime($req->appdate));
        }else{
            $ndate = '';
        }
        return Appointment::with(['user', 'training_center'])
            ->where('appointment_user_id', $user->user_id)
            ->where('app_date', 'like',  $ndate . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

//        return Appointment::from('appointments as a')
//            ->join('appointment_types as b', 'a.appointment_type_id', 'b.appointment_type_id')
//            ->join('offices as c', 'b.office_id', 'c.office_id')
//            ->where('appointment_user_id', $user->user_id)
//            ->where('app_date', 'like',  $ndate . '%')
//            ->orderBy($sort[0], $sort[1])
//            ->paginate($req->perpage);
    }

    public function upcomingAppointment(){
        $data = DB::table('appointments as a')
            ->join('users as b', 'a.appointment_user_id', 'b.user_id')
            ->join('training_centers as c', 'a.training_center_id', 'c.training_center_id')
            ->orderBy('appointment_id', 'desc')
            ->where('b.user_id', Auth::user()->user_id)
            ->first();
        return $data;
    }

    public function store(Request $req){

        $req->validate([
            'app_date' => ['required'],
            'appointment_type' => ['required']
        ], $message = [
            'app_date.required' => 'Please select date and time.',
        ]); //validating input

        $date =  $req->app_date;
        $ndate = date("Y-m-d", strtotime($date)); //convert to date format UNIX

        $time = $req->app_time;
        $ntime = date('H:i:s',strtotime($time)); //convert to format time UNIX

        $appData = AppointmentType::where('appointment_type_id', $req->appointment_type)->first(); //get first the appointment type so we can get the cc_time
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

//        $countExist = DB::table('appointments as a')
//            ->join('appointment_types as b', 'a.appointment_type_id', 'b.appointment_type_id')
//            ->where('app_date', $ndate)
//            ->where('app_time_from', '<=', $ntime)
//            ->where('app_time_to', '>=', $ntime)
//            ->where('a.appointment_type_id', $req->appointment_type)
//            ->count();

        //labad sa ulo ang filtering conflict sa time
        $countExist = DB::table('appointments as a')
            ->join('appointment_types as b', 'a.appointment_type_id', 'b.appointment_type_id')
            ->where('app_date', $ndate)
            ->where(function($query) use ($ntime, $addedTime){
                $query->whereBetween('app_time_from', [$ntime, $addedTime])
                    ->orWhereBetween('app_time_to', [$ntime,$addedTime]);
            })
            ->where('a.appointment_type_id', $req->appointment_type)
            ->count();

        if($countExist >= $max_multiple){
            return response()->json([
                'errors' => [
                    'limit' =>  ['Sorry, no available slot at the moment. Please select another schedule.']
                ]
            ], 422);
        }


        $user = Auth::user();

        Appointment::create([
            'appointment_type_id' => $req->appointment_type,
            'appointment_user_id' => $user->user_id,
            'app_date' => $ndate,
            'app_time_from' => $ntime,
            'app_time_to' => $addedTime,
            'visit_status' => 'PENDING'
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);


    }

    public function cancelMyAppointment($id){
        $data = Appointment::find($id);
        $data->app_status = 2;
        $data->save();

        return response()->json([
            'status' => 'cancelled'
        ],200);
    }
}
