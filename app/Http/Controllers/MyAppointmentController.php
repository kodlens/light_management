<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;


class MyAppointmentController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('user');
    }

    public function index(){
        $services = Service::orderBy('service', 'asc')->get();
        $user = Auth::user();
        return view('my-appointment')
            ->with('services', $services)
            ->with('user', $user);
    }


    public function show($id){

        $data = DB::table('appointments as a')
            ->join('users as b', 'a.dentist_id', 'b.user_id')
            ->join('services as d', 'a.service_id', 'd.service_id')
            ->join('users as c', 'a.user_id', 'c.user_id')
            ->select('a.appointment_id', 'a.user_id', 'a.appoint_date', 'a.appoint_time', 'a.dentist_id', 'a.appoint_status',
                'b.lname as dentist_lname', 'b.fname as dentist_fname', 'b.mname as dentist_mname', 'b.contact_no as dentist_contact_no',
                'c.lname as user_lname', 'c.fname as user_fname', 'c.mname as user_mname', 'c.sex as user_sex', 'c.contact_no as user_contact_no',
                'd.service_id', 'd.service', 'd.price')
            ->where('a.appointment_id', $id)
            ->first();


        return $data;
    }

    public function getMyAppointments(Request $req){
        $sort = explode('.', $req->sort_by);
        $user = Auth::user();


        $data = DB::table('appointments as a')
            ->join('users as b', 'a.dentist_id', 'b.user_id')
            ->join('services as d', 'a.service_id', 'd.service_id')
            ->join('users as c', 'a.user_id', 'c.user_id')
            ->select('a.appointment_id', 'a.user_id', 'a.appoint_date', 'a.appoint_time', 'a.dentist_id', 'a.appoint_status',
                'b.lname as dentist_lname', 'b.fname as dentist_fname', 'b.mname as dentist_mname', 'b.contact_no as dentist_contact_no',
                'c.lname as user_lname', 'c.fname as user_fname', 'c.mname as user_mname', 'c.sex as user_sex', 'c.contact_no as user_contact_no',
                'd.service_id', 'd.service', 'd.price')
            ->where('a.user_id', $user->user_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function cancelMyAppointment($id){

        $data = Appointment::find($id);
        $data->appoint_status = 2;
        $data->save();

        return response()->json([
            'status' => 'canceled'
        ], 200);

    }


    public function store(Request $req){
        $req->validate([
            'appointment_date' => ['required']
        ]);

        $user = Auth::user();

        $qr_code = substr(md5(time() . $user->lname . $user->fname), -8);

        $date =  $req->appointment_date; //date and time
        $ndate = date("Y-m-d", strtotime($date)); //convert to date format UNIX
        $ntime = date("H:i:s", strtotime($date)); //convert to date format UNIX
        $txtTime = date("H:i A", strtotime($date));

        $appointment = Appointment::create([
            'user_id' => $user->user_id,
            'service_id' => $req->service_id,
            'qr_code' => $qr_code,
            'appoint_date' => $ndate,
            'appoint_time' => $ntime,
            'dentist_id' => $req->dentist_id
        ]);


        $msg = 'Dear '.$user->lname.', '. $user->fname .'. This is Dental Care Services. Thank you for booking with us! Your time and date Schedule:('.$ndate.', '. $txtTime . '). Reference No. :'. $appointment->qr_code;
        try{ 
            Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->post('http://'. env('IP_SMS_GATEWAY') .'/services/api/messaging?Message='.$msg.'&To='.$user->contact_no.'&Slot=1', []);
        }catch(Exception $e){} //just hide the error


        return response()->json([
            'status' => 'saved'
        ],200);
    }


    public function update(Request $req, $id){
        $req->validate([
            'appointment_date' => ['required']
        ]);
        $date =  $req->appointment_date; //date and time
        $ndate = date("Y-m-d", strtotime($date)); //convert to date format UNIX
        $ntime = date("H:i:s", strtotime($date)); //convert to date format UNIX

        $data = Appointment::find($id);

        $data->service_id = $req->service_id;
        $data->appoint_date = $ndate;
        $data->appoint_time = $ntime;
        $data->dentist_id = $req->dentist_id;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ],200);
    }

    public function changePassword(Request $req){

        //return $req;

        $req->validate([
            'password' => ['required', 'confirmed']
        ]);

        $user = Auth::user();
        $hashedPassword = $user->password;
        $id = $user->user_id;

        if (Hash::check($req->old_password, $hashedPassword)) {
            // The passwords match...
            $data = User::find($id);
            $data->password = Hash::make($req->password);
            $data->save();

            return response()->json([
                'status' => 'changed'
            ],200);
        }

        return response()->json([
            'status' => 'password_error'
        ],406);
    }

}
