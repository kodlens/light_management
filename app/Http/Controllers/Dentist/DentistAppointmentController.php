<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use App\Models\Service;
use App\Models\Appointment;
use App\Models\Admit;
use App\Models\User;

use Auth;



class DentistAppointmentController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('dentist');

    }

    public function index(){
        $services = Service::orderBy('service', 'asc')->get();
        return view('dentist.dentist-appointment')
            ->with('services', $services);
    }

    public function getAppointments(Request $req){
        $user = Auth::user();

        $sort = explode('.', $req->sort_by);

        $data = DB::table('appointments as a')
            ->join('users as c', 'a.dentist_id', 'c.user_id')
            ->join('services as d', 'a.service_id', 'd.service_id')
            ->join('users as e', 'a.user_id', 'e.user_id')
            ->select('a.*', 'c.lname as dentist_lname', 'c.fname as dentist_fname', 'c.mname as dentist_mname', 'd.*', 'e.lname as user_lname',
                'e.fname as user_fname', 'e.mname as user_mname', 'e.contact_no as user_contact_no')
            ->where('a.dentist_id', $user->user_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function approveAppointment($id){
        $data = Appointment::find($id);
        $data->appoint_status = 1;
        $data->save();

        return response()->json([
            'status' => 'approved'
        ],200);
    }

    public function cancelAppointment($id){
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
        ],200);
    }

    public function pendingAppointment($id){
        $data = Appointment::find($id);
        $data->appoint_status = 0;
        $data->save();

        return response()->json([
            'status' => 'pending'
        ],200);
    }


    public function admitAppointment($id){
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

        return response()->json([
            'status' => 'saved'
        ],200);
    }


    public function servicesLog(Request $req){
        return view('dentist.services-log')
            ->with('patient', $req->patient)
            ->with('appid', $req->appid);
    }


    public function getServicesLog(Request $req){
        $data = DB::table('appointments as a')
            ->join('appointment_services as b', 'a.appointment_id', 'b.appointment_id')
            ->join('services as c', 'b.service_id', 'c.service_id')
            ->where('a.appointment_id', $req->appid)
            ->get();

        return $data;
    }





}
