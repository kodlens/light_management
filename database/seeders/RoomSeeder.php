<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
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
            //BLDG 1
            [
                'building_id' => 1,
                'floor_id' => 1,
                'room' => 'ROOM 101',
            ],
            [
                'building_id' => 1,
                'floor_id' => 1,
                'room' => 'ROOM 102',
            ],
            [
                'building_id' => 1,
                'floor_id' => 2,
                'room' => 'ROOM 201',
            ],
            [
                'building_id' => 1,
                'floor_id' => 2,
                'room' => 'ROOM 202',
            ],

            //BLDG 2
            [
                'building_id' => 2,
                'floor_id' => 1,
                'room' => 'ROOM 111',
            ],
            [
                'building_id' => 2,
                'floor_id' => 1,
                'room' => 'ROOM 112',
            ],
            
            
        ];

        \App\Models\Room::insertOrIgnore($data);


    }
}
