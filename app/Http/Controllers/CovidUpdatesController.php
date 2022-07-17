<?php

namespace App\Http\Controllers;

use App\Models\Ordinance;
use Illuminate\Http\Request;

class CovidUpdatesController extends Controller
{
     public function index()
    {

        return view('covid-updates');
    }

    public function getOrdinances(){
        $data = Ordinance::orderBy('ordinance_id', 'asc')
            ->get();
        return $data;
    }


}
