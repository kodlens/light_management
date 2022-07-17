<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use App\Models\AppointmentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyAppointmentTypeController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('office');
    }


    public function index(){
        return view('office.my-appointment-type');
    }


    public function show($id){
        return AppointmentType::find($id);
    }


    public function getOffice(Request $req){

        $user = Auth::user();
        $sort = explode('.', $req->sort_by);

        $data = DB::table('appointment_types as a')
            ->join('offices as b', 'a.office_id', 'b.office_id')
            ->where('a.office_id', $user->office_id)
            ->where('a.appointment_type', 'like', $req->type . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function store(Request $req){
        $office_id = Auth::user()->office_id;

        AppointmentType::create([
            'office_id' => $office_id,
            'appointment_type' => strtoupper($req->appointment_type),
            'cc_time' => $req->cc_time,
            'max_multiple' => $req->max_multiple,
            'is_active' => 1,
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){
        $office_id = Auth::user()->office_id;
        $data = AppointmentType::find($id);

        $data->appointment_type = strtoupper($req->appointment_type);
        $data->cc_time = $req->cc_time;
        $data->max_multiple = $req->max_multiple;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function deactivate($id){
        $data = AppointmentType::find($id);
        $data->is_active = 0;
        $data->save();
        return response()->json([
            'status' => 'deactivated'
        ], 200);

    }

    public function activate($id){
        $data = AppointmentType::find($id);
        $data->is_active = 1;
        $data->save();
        return response()->json([
            'status' => 'activated'
        ], 200);

    }


}
