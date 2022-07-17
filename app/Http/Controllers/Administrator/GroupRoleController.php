<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\GroupRole;


class GroupRoleController extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('panel.group-role');
    }

    public function show($id){
        return GroupRole::find($id);
    }

     public function getGroupRoles(Request $req){
         $sort = explode('.', $req->sort_by);


        return GroupRole::where('group_role_name', 'like', $req->floor . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'group_role_name' => ['required', 'unique:group_roles']
        ]);

        GroupRole::create([
            'group_role_name' => strtoupper($req->group_role_name)
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function update(Request $req, $id){

        $req->validate([
            'group_role_name' => ['required', 'unique:group_roles,group_role_name,'. $id . ',group_role_id']
        ]);

        $data = GroupRole::find($id);
        $data->group_role_name = strtoupper($req->group_role_name);
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
