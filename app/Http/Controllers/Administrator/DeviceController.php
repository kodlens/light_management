<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;


use App\Models\Device;

use App\Models\Syslog;
use Auth;

use App\Http\Controllers\Controller;

class DeviceController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }
    
    public function index(){
        return view('panel.device');
    }

    public function loadDevices(){
        return Device::orderBy('device_name', 'asc')
            ->get();
    }

    public function getDevices(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = Device::with(['room'])
            ->where('device_name', 'like', $req->device . '%')
            //->whereBetween('date_from', [$nDateFrom, $nDateTo])
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function show($id){
        return Device::with(['room'])
            ->find($id);
    }

    public function store(Request $req){
       
        $req->validate([
            'room' => ['required'],
            'device_name' => ['required', 'unique:devices'],
            'device_ip' => ['required', 'unique:devices'],
            'device_token_on' => ['required'],
            'device_token_off' => ['required'],
        ]);

        $data = Device::create([
            'room_id' => $req->room,
            'device_name' => strtoupper($req->device_name),
            'device_ip' => $req->device_ip,
            'device_token_on' => $req->device_token_on,
            'device_token_off' => $req->device_token_off,
            
        ]);

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Device ' .$data->device_id . '('. $data->device_name.') created.',
            'action_type' => 'INSERT',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'room' => ['required'],
            'device_name' => ['required'],
            'device_ip' => ['required', 'unique:devices,device_ip,' . $id . ',device_id'],
            'device_token_on' => ['required'],
            'device_token_off' => ['required'],
        ]);
        
        $data = Device::find($id);
        $data->room_id = $req->room;
        $data->device_name = strtoupper($req->device_name);
        $data->device_ip = $req->device_ip;
        $data->device_token_on = $req->device_token_on;
        $data->device_token_off = $req->device_token_off;
        $data->save();

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Device ' .$data->device_id . '('. $data->device_name.') updated.',
            'action_type' => 'UPDATE',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){
        $data = Device::find($id);
        Device::destroy($id);
        
        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Device ' .$data->device_id . '('. $data->device_name.') deleted.',
            'action_type' => 'DELETE',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

}
