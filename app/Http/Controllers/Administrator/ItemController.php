<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Item;


class ItemController extends Controller
{

    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');

    }


    public function index(){
        return view('administrator.item');
    }


    public function show($id){
        return Item::find($id);
    }


    public function getItems(Request $req){
        //for Item Management
        $sort = explode('.', $req->sort_by);

        return Item::where('item_name', 'like', $req->itemname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function getBrowseItems(Request $req){
        //For Modal Browse Item
        $sort = explode('.', $req->sort_by);

        return Item::where('item_name', 'like', '%' . $req->itemname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }




    //store
    public function store(Request $req){


        $req->validate([
            'item_name' => ['required', 'unique:items'],
            'item_type' => ['required'],
            'qty' => ['required', 'min:0']
        ]);

        $item = Item::create([
            'item_name' => strtoupper($req->item_name),
            'item_type' => strtoupper($req->item_type),
            'qty' => $req->qty
        ]);



        return response()->json([
            'status' => 'saved'
        ],200);
    }

    //update
    public function update(Request $req, $id){

        $req->validate([
            'item_name' => ['required', 'unique:items,item_name,'. $id .',item_id'],
            'item_type' => ['required'],
            'qty' => [ 'min:0']
        ]);

        $data = Item::find($id);
        $data->item_name = strtoupper($req->item_name);
        $data->item_type = strtoupper($req->item_type);
        $data->qty = $req->qty === null ? 0 : $req->qty;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ], 200);
    }


    //delete
    public function destroy($id){
        Item::destroy($id);
        return response()->json([
            'status' => 'deleted'
        ],200);
    }


}
