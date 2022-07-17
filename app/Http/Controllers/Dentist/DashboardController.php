<?php

namespace App\Http\Controllers\Dentist;

use App\Http\Controllers\Controller;
use App\Models\Admit;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('dentist');

    }

    public function index(){
        return view('dentist.dentist-dashboard');
    }


    public function getDashboardInfo(){
        $user = Auth::user();
        $admit = Admit::where('dentist_id', $user->user_id)
            ->count();

        $appointment = Appointment::where('dentist_id', $user->user_id)
            ->count();

        return response()->json([
            'admit' => $admit,
            'appointment' => $appointment
        ],200);
    }




}
