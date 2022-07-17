<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DentistScheduleSeeder extends Seeder
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
                'user_id' => 6,
                'from' => '08:00:00',
                'to' => '09:00:00',
                'mon' => 1,
                'tue' => 0,
                'wed' => 1,
                'thur' => 0,
                'fri' => 1,
                'sat' => 0,
                'sun' => 0,
            ],
            [
                'user_id' => 6,
                'from' => '10:00:00',
                'to' => '11:30:00',
                'mon' => 1,
                'tue' => 0,
                'wed' => 1,
                'thur' => 0,
                'fri' => 1,
                'sat' => 0,
                'sun' => 0,
            ],

            [
                'user_id' => 5,
                'from' => '08:00:00',
                'to' => '09:00:00',
                'mon' => 1,
                'tue' => 1,
                'wed' => 1,
                'thur' => 1,
                'fri' => 1,
                'sat' => 0,
                'sun' => 0,
            ],

            [
                'user_id' => 5,
                'from' => '10:00:00',
                'to' => '11:00:00',
                'mon' => 1,
                'tue' => 1,
                'wed' => 1,
                'thur' => 1,
                'fri' => 1,
                'sat' => 0,
                'sun' => 0,
            ],


        ];

        \App\Models\DentistSchedule::insertOrIgnore($data);

    }
}
