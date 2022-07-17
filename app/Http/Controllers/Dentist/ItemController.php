<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Item;


class ItemController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }





    public function getItems(Request $req){
        //for Item Management
        $sort = explode('.', $req->sort_by);

        return Item::where('item_name', 'like', $req->itemname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function getBrowseItems(Request $req){
        //For Modal Browe Item

        $sort = explode('.', $req->sort_by);

        return Item::where('item_name', 'like', '%' . $req->itemname . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }


}
