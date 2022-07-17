<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Room;


class RoomController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('panel.room');
    }

    public function show($id){
        return Room::with(['building', 'floor'])
            ->find($id);
    }

     public function getRooms(Request $req){
         $sort = explode('.', $req->sort_by);


        return Room::with(['building', 'floor'])
            ->where('room', 'like', $req->room . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'building' => ['required'],
            'floor' => ['required'],
            'room' => ['required', 'unique:rooms']
        ]);

        Room::create([
            'building_id' => $req->building,
            'floor_id' => $req->floor,
            'room' => strtoupper($req->room)
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'building' => ['required'],
            'floor' => ['required'],
            'room' => ['required', 'unique:rooms,room,'. $id . ',room_id']
        ]);

        $data = Room::find($id);
        $data->building_id = $req->building;
        $data->floor_id = $req->floor;
        $data->room = strtoupper($req->room);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){

        GroupRole::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);

    }


}
