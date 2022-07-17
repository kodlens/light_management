<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        return view('administrator.report.report-track');
    }

    public function reportInventory(){
        $items = Item::all();
        return view('administrator.report.report-inventory')
            ->with('items', $items);
    }



    //appointment
    public function reportAppointment(){
        return view('administrator.report.report-appointment');
    }

    public function getReportAppointment(Request $req){
        $from = $req->from;
        $to = $req->to;


        $nfrom = date("Y-m-d", strtotime($from)); //convert to date format UNIX
        $nto = date("Y-m-d", strtotime($to)); //convert to date format UNIX

        $data = DB::table('appointments as a')
            ->join('users as b', 'a.dentist_id', 'b.user_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->join('users as d', 'a.user_id', 'd.user_id')
            ->select('a.*', 'b.lname as dentist_lname', 'b.fname as dentist_fname',
                'b.mname as dentist_mname',
                'c.*', 'd.lname as user_lname', 'd.fname as user_fname', 'd.mname as user_mname')
            ->whereBetween('appoint_date', [$nfrom, $nto])
            ->get();
        return $data;
    }

    public function printAppointment(Request $req){
        $from = $req->from;
        $to = $req->to;


        $nfrom = date("Y-m-d", strtotime($from)); //convert to date format UNIX
        $nto = date("Y-m-d", strtotime($to)); //convert to date format UNIX

        $data = DB::table('appointments as a')
            ->join('users as b', 'a.dentist_id', 'b.user_id')
            ->join('services as c', 'a.service_id', 'c.service_id')
            ->join('users as d', 'a.user_id', 'd.user_id')
            ->select('a.*', 'b.lname as dentist_lname', 'b.fname as dentist_fname',
                'b.mname as dentist_mname',
                'c.*', 'd.lname as user_lname', 'd.fname as user_fname', 'd.mname as user_mname')
            ->whereBetween('appoint_date', [$from, $to])
            ->get();
        return view('administrator.report.print.print-appointment')
            ->with('data', $data);
    }



}
