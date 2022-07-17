<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;



use Illuminate\Support\Facades\DB;


use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Device;

use App\Models\GroupRole;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Auth::routes([
    'login' => false
]);

// Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index']);
 Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/sign-up', [App\Http\Controllers\SignUpController::class, 'index']);

Route::post('/sign-up', [App\Http\Controllers\SignUpController::class, 'store']);





//ADDRESS
//Route::get('/load-provinces', [App\Http\Controllers\AddressController::class, 'loadProvinces']);
//Route::get('/load-cities', [App\Http\Controllers\AddressController::class, 'loadCities']);
//Route::get('/load-barangays', [App\Http\Controllers\AddressController::class, 'loadBarangays']);




/*     ADMINSITRATOR/CPANEL      */

//cpanel

Route::get('/init-user', function(){
    return Auth::user();
});

Route::resource('/cpanel', App\Http\Controllers\Administrator\CpanelController::class);

//loading switch for buildings
Route::get('/load-switch-buildings', [App\Http\Controllers\Administrator\DeviceOpenController::class, 'loadSwitchBuildings']);


//buildings
Route::resource('/buildings', App\Http\Controllers\Administrator\BuildingController::class);
Route::get('/get-buildings', [App\Http\Controllers\Administrator\BuildingController::class, 'getBuildings']);


//floors
Route::resource('/floors', App\Http\Controllers\Administrator\FloorController::class);
Route::get('/get-floors', [App\Http\Controllers\Administrator\FloorController::class, 'getFloors']);

//rooms
Route::resource('/rooms', App\Http\Controllers\Administrator\RoomController::class);
Route::get('/get-rooms', [App\Http\Controllers\Administrator\RoomController::class, 'getRooms']);


//group roles
Route::resource('/group-roles', App\Http\Controllers\Administrator\GroupRoleController::class);
Route::get('/get-group-roles', [App\Http\Controllers\Administrator\GroupRoleController::class, 'getGroupRoles']);



//devices
Route::resource('/devices', App\Http\Controllers\Administrator\DeviceController::class);
Route::get('/get-devices', [App\Http\Controllers\Administrator\DeviceController::class, 'getDevices']);


//devices
Route::resource('/device-accesses', App\Http\Controllers\Administrator\DeviceAccessController::class);
Route::get('/get-device-accesses', [App\Http\Controllers\Administrator\DeviceAccessController::class, 'getDevicesAccesses']);

Route::get('/load-access-role-if-any/{id}', [App\Http\Controllers\Administrator\DeviceAccessController::class, 'loadAccessRoleIfAny']);



//Schedule
Route::resource('/schedules', App\Http\Controllers\Administrator\ScheduleController::class);
Route::get('/get-schedules', [App\Http\Controllers\Administrator\ScheduleController::class, 'getSchedules']);



//User
Route::resource('/users', App\Http\Controllers\Administrator\UserController::class);
Route::get('/get-users', [App\Http\Controllers\Administrator\UserController::class, 'getUsers']);
Route::get('/get-user-offices', [App\Http\Controllers\Administrator\UserController::class, 'getOffices']);



Route::resource('/syslogs', App\Http\Controllers\Administrator\SyslogController::class);
Route::get('/get-syslogs', [App\Http\Controllers\Administrator\SyslogController::class, 'getSyslogs']);

//Offices Administrator (For office management)

/*     ADMINSITRATOR          */



//for logs purpose
Route::get('/switch-log', [App\Http\Controllers\Administrator\SwitchLogController::class, 'store']);


Route::get('/load-buildings', function(){
    return Building::all();
});
Route::get('/load-floors', function(){
    return Floor::all();
});

Route::get('/load-open-rooms', function(){
    return Room::orderBy('room', 'asc')->get();
});

Route::get('/load-open-devices', function(){
    return Device::with('room')->orderBy('device_name', 'asc')->get();
});
Route::get('/load-open-group-roles', function(){
    return GroupRole::orderBy('group_role_name', 'asc')
        ->select('group_role_id', 'group_role_name')
        ->get();
});




Route::get('/session', function(){
    return Session::all();
});


Route::get('/applogout', function(Request $req){
    \Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();


});


Route::get('/s', function(){
    $day = date('D');
    
    $sched = DB::table('schedules as a')
        ->join('devices as b', 'a.device_id', 'b.device_id')
        ->where($day, 1)
        ->get();
    
    return $sched;

    $time = date('H:i') . ':00';

    foreach($sched as $i){
        if($time === $i->schedule_on){
            return 'turn on';
        }
    
        if($time === $i->schedule_off){
            return 'turn off';
        }
    }

});

Route::get('/test', function(){
    
    $sched = DB::table('schedules as a')
                ->join('devices as b', 'a.device_id', 'b.device_id')
                ->where('date_time', date("Y-m-d H:i"))
                ->get();

    foreach($sched as $i){
        if($i->system_action == 'ON'){
            Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->get('http://'.$i->device_ip . '/' . $i->device_token_on, []);
        }else{
            Http::withHeaders([
                'Content-Type' => 'text/plain'
            ])->get('http://'.$i->device_ip . '/' . $i->device_token_off, []); 
        }
    }

});

Route::get('/test-switch', function(){
    return 'ON';
});