<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\AdmitService;


class DentistAdmitServiceController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $req){
        return view('dentist.dentist-service-log-inv')
            ->with('serviceid', $req->serviceid);
    }

    public function getAdmitServices($admitid, $toothid){

        /*$data = DB::table('admit_services as a')
            ->join('admits as b', 'a.admit_id', 'b.admit_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->join('teeth as d', 'a.tooth_id', 'd.tooth_id')
            ->select('a.admit_service_id', 'a.admit_id', 'a.service_id', 'a.tooth_id', 'b.patient_id', 'b.qr_code', 'b.dentist_id', 'b.created_at',
                'c.service', 'c.description', 'c.price', 'd.tooth_name')
            ->where('a.admit_id', $admitid)
            ->where('a.tooth_id', $toothid)
            ->get();*/

        $data = AdmitService::with(['service_inventories', 'services', 'teeth'])
            ->where('admit_id', $admitid)
            ->where('tooth_id', $toothid)
            ->get();

        return $data;
    }



    public function store(Request $req){

        $req->validate([
            'service' => ['required']
        ],
        $message = [
            'service.required' => 'Service is required.'
        ]);

        AdmitService::create([
            'admit_id' => $req->admit_id,
            'service_id' => $req->service,
            'tooth_id' => $req->tooth_id,
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
        AdmitService::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ],200);
    }


}
