<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicesController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('admin');

    }


    public function index(){
        return view('administrator.services-page');
    }

    public function getServices(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = \DB::table('services as a')
            ->where('a.service', 'like', $req->service . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);

        return $data;
    }



    public function getAllServices(Request $req){
        $sort = explode('.', $req->sort_by);

        $data = \DB::table('services as a')
            ->orderBy('service', 'asc')
            ->get();

        return $data;
    }

    //getDentalServices cater the welcome page
    public function getDentalServices(){
        return \DB::table('services')
            ->orderBy('service_id', 'asc')
            ->get();
    }

    public function show($id){
        return Service::find($id);
    }



    public function store(Request $req){
        $req->validate([
            'service' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
        ]);

        Service::create([
            'service' => $req->service,
            'description' => $req->description,
            'price' => $req->price,
        ]);

        return response()->json([
            'status' => 'saved'
        ],200);
    }

    public function update(Request $req, $id){

        $validate = $req->validate([
            'service' => ['required', 'string', 'unique:services,service,' .$id .',service_id'],
            'price' => ['required'],
        ]);


        $data = Service::find($id);
        $data->service = $req->service;
        $data->description = $req->description;
        $data->price = $req->price;
        $data->save();

        return response()->json([
            'status' => 'updated'
        ],200);
    }

    public function destroy($id){
        Service::destroy($id);
    }

}
