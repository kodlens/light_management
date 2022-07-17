<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RequestAppointment extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
    }


    public function index(){
        return view('administrator.user.request-appointment');
    }

    public function getAppointments(Request $req){
        $sort = explode('.', $req->sort_by);

        return Appointment::where('ordinance_name', 'like', $req->ordinance . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){

        $req->validate([
            'ordinance_name' => ['required'],
            'ordinance_img_path' => ['required', 'mimes:jpg,png,bmp']
        ], $message = [
            'ordinance_img_path.mimes' => 'Type of the file must be jpg, png or bmp.',
            'ordinance_img_path.required' => 'Image is required.'
        ]);

        $ordinanceImg = null;
        //upload image b house
        $ordinanceImg = $req->file('ordinance_img_path');
        if($ordinanceImg){
            $pathFile = $ordinanceImg->store('public/ordinances'); //get path of the file
            $ordinancePath = explode('/', $pathFile); //split into array using /
        }

        Ordinance::create([
            'ordinance_name' => strtoupper($req->ordinance_name),
            'ordinance_img_path' => $ordinancePath[2] != null ? $ordinancePath[2]: '',
        ]);

        return response()->json([
            'status' => 'saved'
        ], 200);
    }

    public function destroy($id){
        $data = Ordinance::find($id);
        if(Storage::exists('public/ordinances/' .$data->ordinance_img_path)) {
            Storage::delete('public/ordinances/' . $data->ordinance_img_path);
        }
        Ordinance::destroy($id);

        return response()->json([
            'status' => 'deleted'
        ]);
    }
}
