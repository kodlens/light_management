<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Admit;


class DentistServicePatientController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $req){

        $data = DB::table('admits as a')
            ->join('users as b', 'a.patient_id', 'b.user_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->where('admit_id', $req->admitid)
            ->select('a.*', 'b.lname', 'b.fname', 'b.mname', 'c.*')
            ->first();


        return view('dentist.dentist-service-patient')
            ->with('data', $data)
            ->with('toothid', $req->toothid)
            ->with('admitid', $req->admitid);
    }



    public function show($id){
        
    }


    public function store(Request $req){

        $req->validate([
            'item_name' => ['required', 'unique:items']
        ]);

        Item::create([
            'item_name' => strtoupper($req->item_name)
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
        Item::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ],200);
    }


}
