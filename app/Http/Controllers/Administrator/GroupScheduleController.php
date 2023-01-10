<?php

namespace App\Http\Controllers\Administrator;

use App\Models\GroupRole;
use App\Models\GroupScheduleDevice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\GroupSchedule;


class GroupScheduleController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('panel.group-schedule');
    }

    public function create(){
        return view('panel.group-schedule-create-update')
            ->with('id', 0);
    }


    public function groupSchedules(Request $req){
        $sort = explode('.', $req->sort_by);

        //$dateFrom =  $req->date_from;
        //$nDateFrom = date("Y-m-d", strtotime($dateFrom)); //convert to date format UNIX

        //$dateTo = $req->date_to;
       // $nDateTo = date('H:i:s',strtotime($dateTo)); //convert to format time UNIX

        $data = GroupSchedule::with(['group_schedule_devices'])
            //->whereBetween('date_from', [$nDateFrom, $nDateTo])
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }

    public function store(Request $req){
        //return $req;

        if($req->action_type == 0){
            $req->validate([
                'schedule_name' => ['required'],
                 'date_time' => ['required'],
                // 'system_action' => ['required'],
                // 'action_type' => ['required'],
                //'schedule_on' => ['required'],
                //'schedule_off' => ['required'],
            ]);
        }else{
            $req->validate([
                'schedule_name' => ['required'],
                //'date_time' => ['required'],
                // 'system_action' => ['required'],
                // 'action_type' => ['required'],
                'schedule_on' => ['required'],
                'schedule_off' => ['required'],
            ]);
        }

        if($req->action_type == 0){
            $dateTime =  $req->date_time;
            $nDateTime = date("Y-m-d H:i:s", strtotime($dateTime)); //convert to date format UNIX
        }else{
            $scheduleOn = date("H:i:s", strtotime($req->schedule_on)); //convert to date format UNIX
            $scheduleOff = date("H:i:s", strtotime($req->schedule_off)); //convert to date format UNIX
        }

        $user = Auth::user();

        $data = GroupSchedule::create([
            'schedule_name' => $req->schedule_name,
            'date_time' => $req->action_type == 0 ? $nDateTime : null,
            'system_action' => $req->action_type == 0 ? $req->system_action : null,
            'action_type' => $req->action_type,
            'schedule_on' => $req->action_type == 1 ? $scheduleOn : null,
            'schedule_off' => $req->action_type == 1 ? $scheduleOff : null,
            'mon' => $req->mon,
            'tue' => $req->tue,
            'wed' => $req->wed,
            'thu' => $req->thu,
            'fri' => $req->fri,
            'sat' => $req->sat,
            'sun' => $req->sun,
        ]);

        foreach($req->devices as $device){
            GroupScheduleDevice::create([
                'group_schedule_id' => $data->group_schedule_id,
                'device_id' => $device['device_id']
            ]);
        }

        return response()->json([
            'status' => 'saved'
        ], 200);
    }


    public function edit($id){

        $data = GroupSchedule::with(['group_schedule_devices'])
            ->find($id);

        return view('panel.group-schedule-create-update')
            ->with('data', $data)
            ->with('id', $id);
    }

    public function update(Request $req, $id){

        if($req->action_type == 0){
            $req->validate([
                'schedule_name' => ['required'],
                'date_time' => ['required'],
            ]);
        }else{
            $req->validate([
                'schedule_name' => ['required'],
                'schedule_on' => ['required'],
                'schedule_off' => ['required'],
            ]);
        }

        if($req->action_type == 0){
            $dateTime =  $req->date_time;
            $nDateTime = date("Y-m-d H:i:s", strtotime($dateTime)); //convert to date format UNIX
        }else{
            $scheduleOn = date("H:i:s", strtotime($req->schedule_on)); //convert to date format UNIX
            $scheduleOff = date("H:i:s", strtotime($req->schedule_off)); //convert to date format UNIX
        }


        $data = GroupSchedule::find($id);
        $data->schedule_name  = $req->schedule_name;
        $data->date_time = $req->action_type == 0 ? $nDateTime : null;
        $data->system_action = $req->action_type == 0 ? $req->system_action : null;
        $data->schedule_on = $req->action_type == 1 ? $scheduleOn : null;
        $data->schedule_off = $req->action_type == 1 ? $scheduleOff : null;

        $data->mon = $req->mon;
        $data->tue = $req->tue;
        $data->wed = $req->wed;
        $data->thu = $req->thu;
        $data->fri = $req->fri;
        $data->sat = $req->sat;
        $data->sun = $req->sun;

        $data->save();

        foreach($req->devices as $device){
            GroupScheduleDevice::updateOrCreate([
                'group_schedule_id' => $data->group_schedule_id,
                'device_id' => $device['device_id']
            ],[
                'group_schedule_id' => $data->group_schedule_id,
                'device_id' => $device['device_id']
            ]);
        }

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function deleteGroupScheduleDevice($id){
        GroupScheduleDevice::destroy($id);

        return response()->json([
            'status' => 'delete'
        ], 200);
    }
    public function destroy($id){
        GroupSchedule::destroy($id);

        return response()->json([
            'status' => 'delete'
        ], 200);
    }

}
