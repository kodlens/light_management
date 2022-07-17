<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;


use App\Models\Device;
use App\Models\Building;

use App\Models\DeviceAccess;


use Auth;

use App\Http\Controllers\Controller;

class DeviceOpenController extends Controller
{
    //


    public function loadSwitchBuildings(Request $req){
        $user = Auth::user();


        return Building::with(['devices' => function($q) use ($user) {
            $q->where('group_role_id', $user->group_role_id)
                ->orderBy('rooms.floor_id', 'desc');
        }])->get();

       
    }


}
