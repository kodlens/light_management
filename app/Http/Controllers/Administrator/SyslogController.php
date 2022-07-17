<?php

namespace App\Http\Controllers\Administrator;

use Illuminate\Http\Request;

use App\Models\Syslog;
use App\Http\Controllers\Controller;

class SyslogController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');

    }

    public function index(){
        return view('panel.syslog');
    }



    public function getSyslogs(Request $req){
        $sort = explode('.', $req->sort_by);

        // $dateFrom =  $req->date_from;
        // $nDateFrom = date("Y-m-d", strtotime($dateFrom)); //convert to date format UNIX

        // $dateTo = $req->date_to;
        // $nDateTo = date('H:i:s',strtotime($dateTo)); //convert to format time UNIX

        
        $data = Syslog::where('syslog', 'like', $req->activity . '%')
            ->orderBy($sort[0], $sort[1])
            ->paginate($req->perpage);
        return $data;
    }
}
