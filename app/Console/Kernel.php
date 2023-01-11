<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->call(function () {
            $day = date('D');

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



            $sched = DB::table('schedules as a')
                ->join('devices as b', 'a.device_id', 'b.device_id')
                ->where($day, 1)
                ->get();

            $time = date('H:i') . ':00';

            foreach($sched as $i){
                if($time === $i->schedule_on){
                    Http::withHeaders([
                        'Content-Type' => 'text/plain'
                    ])->get('http://'.$i->device_ip . '/' . $i->device_token_on, []);
                    return 'turn on';
                }

                if($time === $i->schedule_off){
                    Http::withHeaders([
                        'Content-Type' => 'text/plain'
                    ])->get('http://'.$i->device_ip . '/' . $i->device_token_off, []);
                }
            }



            //group schedule
            $sched = DB::table('group_schedules as a')
                ->join('group_schedule_devices as b', 'a.group_schedule_id', 'b.group_schedule_id')
                ->join('devices as c', 'b.device_id', 'c.device_id')
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




            $sched = DB::table('group_schedules as a')
                ->join('group_schedule_devices as b', 'a.group_schedule_id', 'b.group_schedule_id')
                ->join('devices as c', 'b.device_id', 'c.device_id')
                ->where($day, 1)
                ->get();

            $time = date('H:i') . ':00';

            foreach($sched as $i){
                if($time === $i->schedule_on){
                    Http::withHeaders([
                        'Content-Type' => 'text/plain'
                    ])->get('http://'.$i->device_ip . '/' . $i->device_token_on, []);
                    return 'turn on';
                }

                if($time === $i->schedule_off){
                    Http::withHeaders([
                        'Content-Type' => 'text/plain'
                    ])->get('http://'.$i->device_ip . '/' . $i->device_token_off, []);
                }
            }


        })->everyMinute(); //loop everyminute
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
