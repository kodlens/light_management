<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdmitServiceSeeder extends Seeder
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
                'admit_id' => 1,
                'service_id' => 2,
                'tooth_id' => 16,
            ],
             [
                'admit_id' => 1,
                'service_id' => 6,
                'tooth_id' => 16,
            ],
          
           
        ];

        \App\Models\AdmitService::insertOrIgnore($data);

    }
}
