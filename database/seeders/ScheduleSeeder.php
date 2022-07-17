<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         $data = [
            [
                'device_id' => 1,
                'schedule_name' => 'TEST SCHEDULE 1',
                // 'date_time' => '2021-04-17 12:52:11',
                // 'system_action' => 'ON',
                // 'action_type' => 'REPEAT',
                'schedule_on' => '07:00:00',
                'schedule_off' => '17:00:00',
                'ntuser' => 'ADMIN',
            ],
            [
                'device_id' => 1,
                'schedule_name' => 'TEST SCHEDULE 2',
                // 'date_time' => '2021-04-17 09:00:00',
                // 'system_action' => 'OFF',
                // 'action_type' => 'REPEAT',
                'schedule_on' => '07:00:00',
                'schedule_off' => '17:00:00',
                'ntuser' => 'ADMIN',
            ],
            
        ];

        \App\Models\Schedule::insertOrIgnore($data);
    }
}
