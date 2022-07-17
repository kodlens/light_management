<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Dentist;

use App\Models\User;


use Illuminate\Http\Request;

class DentistController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.dentist');
    }

    public function getDentists(Request $req){
        //this is for select box in appointment
        $sort = explode('.',$req->sort_by);
        $data = Dentist::where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }

    public function getBrowseDentist(Request $req){

        $data = User::where('lname', 'like', $req->lname . '%')
            ->where('fname', 'like', $req->fname . '%')
            ->where('role', 'DENTIST')
            ->paginate($req->perpage);
        return $data;
    }

    // public function getBrowseDentist(Request $req){
    //     $data = Dentist::where('lname', 'like', $req->lname . '%')
    //         ->where('fname', 'like', $req->fname . '%')
    //         ->paginate($req->perpage);
    //     return $data;
    // }



    public function loadDentist(){
        return Dentist::all();
    }


    public function show($id){
        return Dentist::find($id);
    }

    public function store(Request $req){

        $req->validate([
            'lname' => ['required'],
            'fname' => ['required'],
            'sex' => ['required'],
            'email' => ['required', 'unique:dentists'],
        ]);

        Dentist::create([
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'suffix' => strtoupper($req->suffix),
            'sex' => strtoupper($req->sex),
            'contact_no' => $req->contact_no,
            'email' => $req->email,
            'address' => strtoupper($req->address),

        ]);

        return response()->json([
            'status' => 'saved'
        ],200);
    }


    public function update(Request $req, $id){
        $req->validate([
            'lname' => ['required'],
            'fname' => ['required'],
            'sex' => ['required'],
            'email' => ['required', 'unique:dentists,email,' . $id . ',dentist_id'],
        ]);

        $data = Dentist::find($id);
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->sex = strtoupper($req->sex);
        $data->contact_no = $req->contact_no;
        $data->email = $req->email;
        $data->address = strtoupper($req->address);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ],200);
    }

    public function destroy($id){
        Dentist::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ],200);
    }



}
