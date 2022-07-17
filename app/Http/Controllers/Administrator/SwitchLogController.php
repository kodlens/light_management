<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\Models\Syslog;


class SwitchLogController extends Controller
{
    //

    public function store(Request $req){
        //return $req;

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Device turned '.$req->status. '. URL is ' . $req->url . '.',
            'action_type'=> $req->status,
            'username' => $user->username
        ]);
    }
}
