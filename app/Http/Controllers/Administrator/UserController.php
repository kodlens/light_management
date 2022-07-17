<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Syslog;

use Auth;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('panel.user'); //blade.php
    }

    public function getUsers(Request $req){
        $sort = explode('.', $req->sort_by);

        $users = User::where('lname', 'like', $req->lname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $users;
    }

    public function show($id){
        return User::with(['group_role'])->find($id);
    }

    public function store(Request $req){
        //this will create random unique QR code
        $qr_code = substr(md5(time() . $req->lname . $req->fname), -8);

        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'confirmed'],
            'role' => ['required', 'string'],
            'group_role' => ['required'],
        ]);

        $data = User::create([
            'qr_ref' => $qr_code,
            'username' => $req->username,
            'password' => Hash::make($req->password),
            'lname' => strtoupper($req->lname),
            'fname' => strtoupper($req->fname),
            'mname' => strtoupper($req->mname),
            'sex' => $req->sex,
            'email' => $req->email,
            'contact_no' => $req->contact_no,
            'role' => $req->role,
            'group_role_id' => $req->group_role,
        ]);

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'User ' .$data->user_id . '('. $data->username.') created.',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'saved'
        ]);
    }

    public function update(Request $req, $id){
        $validate = $req->validate([
            'username' => ['required', 'max:50', 'unique:users,username,'.$id.',user_id'],
            'lname' => ['required', 'string', 'max:100'],
            'fname' => ['required', 'string', 'max:100'],
            'mname' => ['required', 'string', 'max:100'],
            'sex' => ['required', 'string', 'max:20'],
            'email' => ['required', 'unique:users,email,'.$id.',user_id'],
            'role' => ['required', 'string'],
            'group_role' => ['required'],
        ]);

        $data = User::find($id);
        $data->username = $req->username;
        $data->lname = strtoupper($req->lname);
        $data->fname = strtoupper($req->fname);
        $data->mname = strtoupper($req->mname);
        $data->sex = $req->sex;
        $data->email = $req->email;
        $data->role = $req->role;
        $data->group_role_id = $req->group_role;
     
        $data->save();

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'User ' .$data->user_id . '('. $data->username.') updated.',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'updated'
        ]);
    }



    public function destroy($id){
        $data = User::find($id);

        User::destroy($id);


        $user = Auth::user();
        Syslog::create([
            'syslog' => 'User ' .$data->user_id . '('. $data->username.') deleted.',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
