<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\AppointmentService;


class AppointmentServiceController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $req){
        return view('dentist.dentist-service-log-inv')
            ->with('serviceid', $req->serviceid);
    }



   

    public function store(Request $req){

        $req->validate([
            'service' => ['required']
        ],
        $message = [
            'service.required' => 'Service is required.'
        ]);

        AppointmentService::create([
            'appointment_id' => $req->appointment_id,
            'service_id' => $req->service

        ]);

        return response()->json([
            'status' => 'saved'
        ],200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'item_name' => ['required', 'unique:items,item_name,'. $id .',item_id']
        ]);

        $data = Item::find($id);
        $data->item_name = strtoupper($req->item_name);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }



    public function destroy($id){
        AppointmentService::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ],200);
    }


}
