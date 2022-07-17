<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Admit;
use App\Models\User;

use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;



class AppointmentController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $services = Service::orderBy('service', 'asc')->get();

        return view('administrator.appointment')
            ->with('services', $services);
    }

    public function getAppointments(Request $req){

        $sort = explode('.', $req->sort_by);

        $data = DB::table('appointments as a')
            ->join('users as b', 'a.dentist_id', 'b.user_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->join('users as d', 'a.user_id', 'd.user_id')
            ->select('a.*', 'b.lname as dentist_lname', 'b.fname as dentist_fname',
                'b.mname as dentist_mname',
                'c.*', 'd.lname as user_lname', 'd.fname as user_fname', 'd.mname as user_mname', 'd.contact_no as user_contact_no')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function update(Request $req, $id){

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
        ], 200);
    }


    public function appointmentAdmit($id){

        $data = Appointment::find($id);
        $data->appoint_status = 1;
        $data->save();

        Admit::create([
            'appointment_id' => $id,
            'patient_id' => $data->user_id,
            'service_id' => $data->service_id,
            'qr_code' => $data->qr_code,
            'dentist_id' => $data->dentist_id,
        ]);

        $user = User::find($data->user_id);

        $user = User::find($data->user_id);
        $msg = 'Dear '.$user->lname.', '. $user->fname .'. Your appointment with a ref no. '. $data->qr_code.' has been approved. Thank you!';
        try{ 
            Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->post('http://'. env('IP_SMS_GATEWAY') .'/services/api/messaging?Message='.$msg.'&To='.$user->contact_no.'&Slot=1', []);
        }catch(Exception $e){} //just hide the error


        return response()->json([
            'status' => 'admitted'
        ], 200);
    }


    public function appointmentCancel($id){
        //dere ang codeeeeeee!!!!

        $data = Appointment::find($id);
        $data->appoint_status = 2;
        $data->save();

        $user = User::find($data->user_id);

        $msg = 'Dear '.$user->lname.', '. $user->fname .'. Your appointment with a ref no. '. $data->qr_code.' has been canceled. Thank you!';
        try{ 
            Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->post('http://'. env('IP_SMS_GATEWAY') .'/services/api/messaging?Message='.$msg.'&To='.$user->contact_no.'&Slot=1', []);
        }catch(Exception $e){} //just hide the error

        return response()->json([
            'status' => 'cancelled'
        ], 200);

    }


}
