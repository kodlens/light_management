<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Floor;


use Auth;
use App\Models\Syslog;

class FloorController extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('panel.floor');
    }

    public function show($id){
        return Floor::find($id);
    }

     public function getFloors(Request $req){
         $sort = explode('.', $req->sort_by);


        return Floor::where('floor_name', 'like', $req->floor . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'floor_name' => ['required', 'unique:floors']
        ]);

        $data = Floor::create([
            'floor_name' => strtoupper($req->floor_name)
        ]);

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Floor ' .$data->floor_name . ' was inserted.',
            'action_type' => 'INSERT',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'floor_name' => ['required', 'unique:floors,floor_name,'. $id . ',floor_id']
        ]);

        $data = Floor::find($id);
        $data->floor_name = strtoupper($req->floor_name);
        $data->save();

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Floor ' .$data->floor_name . ' was updated.',
            'action_type' => 'UPDATE',
            'username' => $user->username
        ]);


        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){
        $data = Floor::find($id);

        Floor::destroy($id);

        $user = Auth::user();
        Syslog::create([
            'syslog' => 'Floor ' .$data->floor_name . ' was deleted.',
            'action_type' => 'DELETE',
            'username' => $user->username
        ]);

        return response()->json([
            'status' => 'deleted'
        ], 200);

    }


}
