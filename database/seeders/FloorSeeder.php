<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FloorSeeder extends Seeder
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
                'floor_name' => '1ST FLOOR',
            ],
            [
                'floor_name' => '2ND FLOOR',
            ],
      
            
        ];

        \App\Models\Floor::insertOrIgnore($data);


    }
}
