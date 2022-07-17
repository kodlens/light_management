<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DentalChartController extends Controller
{
    //

    public function index(){
        return view('dental-chart');
    }
}
