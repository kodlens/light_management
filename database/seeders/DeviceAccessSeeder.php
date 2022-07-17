<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeviceAccessSeeder extends Seeder
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
                'group_role_id' => 1,
            ],
            [
                'device_id' => 1,
                'group_role_id' => 2,
            ],
            [
                'device_id' => 2,
                'group_role_id' => 1,
            ],

        ];

        \App\Models\DeviceAccess::insertOrIgnore($data);
    }
}
