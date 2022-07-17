<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Item;

use Auth;


class DentistMyPatientController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('dentist.dentist-my-patients');
    }

    public function show($id){
        return Item::find($id);
    }


    public function getAdmitsPatients(Request $req){

        $user = Auth::user();

        $sort = explode('.', $req->sort_by);

        $data = DB::table('admits as a')
            ->join('users as b', 'a.patient_id', 'b.user_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->select('a.*', 'b.lname as patient_lname', 'b.fname as patient_fname', 'b.mname as patient_mname', 'c.*')
            ->where('a.dentist_id', $user->user_id)
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }


    public function getAdmit($id){
        $user = Auth::user();

        $data = DB::table('admits as a')
            ->join('users as b', 'a.patient_id', 'b.user_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->select('a.*', 'b.lname as patient_lname', 'b.fname as patient_fname', 'b.mname as patient_mname', 'c.*')
            ->where('a.admit_id', $id)
            ->first();

        return $data;
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
