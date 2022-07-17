<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
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
                'user_id' => 2,
                'service_id' => 12,
                'qr_code' => '1e6d7c75',
                'appoint_date' => '2022-05-03',
                'appoint_time' => '16:00:00',
                'dentist_id' => '6',
                'appoint_status' => 0,
            ],
            [
                'user_id' => 3,
                'service_id' => 11,
                'qr_code' => '2e6d7c75',
                'appoint_date' => '2022-05-03',
                'appoint_time' => '16:00:00',
                'dentist_id' => '6',
                'appoint_status' => 0,
            ],
           
        ];

        \App\Models\Appointment::insertOrIgnore($data);


    }
}
