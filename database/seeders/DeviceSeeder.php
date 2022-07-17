<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
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
                // 'building_id' => 1,
                'room_id' => 1,
                'device_name' => 'ESP001',
                'device_ip' => '192.168.0.80',
                'device_token_on' => 'a456de76ea5955a9788f948109abf63a',
                'device_token_off' => '8a8b01f2c98adcb340d43c03a3fda69f',
                'ntuser' => 'admin',
            ],
            [
                //'building_id' => 1,
                'room_id' => 2,
                'device_name' => 'ESP002',
                'device_ip' => '192.168.0.81',
                'device_token_on' => '8792f6af87224906dd1e3f93d955e175',
                'device_token_off' => 'b694d23793bd683c2db4b8dd95ad7972',
                'ntuser' => 'admin',
            ],
            [
                //'building_id' => 1,
                'room_id' => 3,
                'device_name' => 'ESP003',
                'device_ip' => '192.168.0.82',
                'device_token_on' => '3acb32107fe68da709472ab947a78c6e',
                'device_token_off' => 'ca83b234be3d155897b358050a3c7a9d',
                'ntuser' => 'admin',
            ],
            [
                //'building_id' => 1,
                'room_id' => 4,
                'device_name' => 'ESP004',
                'device_ip' => '192.168.0.83',
                'device_token_on' => 'fb544adc0adbe717a06e6e1391afcd03',
                'device_token_off' => 'd1894f44e4c99eb258b3a3683c52f40e',
                'ntuser' => 'admin',
            ],

            //2ND BUILDING
            [
                //'building_id' => 2,
                'room_id' => 5,
                'device_name' => 'ESP005',
                'device_ip' => '192.168.0.91',
                'device_token_on' => 'a456de76ea5955a9788f948109abf63a',
                'device_token_off' => '8a8b01f2c98adcb340d43c03a3fda69f',
                'ntuser' => 'admin',
            ],
            [
                //'building_id' => 2,
                'room_id' => 6,
                'device_name' => 'ESP006',
                'device_ip' => '192.168.0.92',
                'device_token_on' => '8792f6af87224906dd1e3f93d955e175',
                'device_token_off' => 'b694d23793bd683c2db4b8dd95ad7972',
                'ntuser' => 'admin',
            ],
          


            
        ];

        \App\Models\Device::insertOrIgnore($data);
    }
}
