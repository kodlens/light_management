<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DentistMyProfileController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('dentist.dentist-my-profile');
    }

    public function myProfile(){
        return Auth::user();
    }

    public function update(Request $req, $id){

        $req->validate([
            'lname' => ['required'],
            'fname' => ['required'],
            'email' => ['required', 'email', 'unique:users,email,' . $id . ',user_id'],
        ]);

        $data = User::find($id);
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->suffix = strtoupper($req->suffix);
        $data->sex = strtoupper($req->sex);
        $data->email = $req->email;
        $data->contact_no = $req->contact_no;

        $data->province = $req->province;
        $data->city = $req->city;
        $data->barangay = $req->barangay;

        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);

    }

}
