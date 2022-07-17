<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Office;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        //$this->middleware('user');
    }

    public function index(){
        return view('user.user-dashboard');
    }

    public function getUser(){
        return Auth::user();
    }



}
