<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdmitSeeder extends Seeder
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
                'patient_id' => 2,
                'service_id' => 12,
                'qr_code' => '1e6d7c75',
                'dentist_id' => '6',
            ],
          
           
        ];

        \App\Models\Admit::insertOrIgnore($data);

    }
}
