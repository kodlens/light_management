<?php


namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Building;

class BuildingController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('panel.building');
    }

    public function show($id){
        return Building::find($id);
    }

     public function getBuildings(Request $req){
         $sort = explode('.', $req->sort_by);


        return Building::where('building_name', 'like', $req->building . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'building_name' => ['required', 'unique:buildings']
        ]);

        Building::create([
            'building_name' => strtoupper($req->building_name)
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'building_name' => ['required', 'unique:buildings,building_name,'. $id . ',building_id']
        ]);

        $data = Building::find($id);
        $data->building_name = strtoupper($req->building_name);
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }

    public function destroy($id){

        Building::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ], 200);

    }


}
