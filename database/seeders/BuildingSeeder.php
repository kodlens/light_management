<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
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
                'building_name' => 'BUILDING 1',
            ],
            [
                'building_name' => 'BUILDING 2',
            ],
      
            
        ];

        \App\Models\Building::insertOrIgnore($data);
    }
}
