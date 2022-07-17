<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DentistSeeder extends Seeder
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
                'lname' => 'LOPEZ',
                'fname' => 'ANGEL',
                'mname' => 'P',
                'suffix' => '',
                'sex' => 'FEMALE',
                'contact_no' => '09161234125',
                'email' => 'angel@dev.com',
                'address' => 'P-6, TANGUB CITY',
            ],
            [
                'lname' => 'ALGADIPE',
                'fname' => 'HEZZEL',
                'mname' => 'P',
                'suffix' => '',
                'sex' => 'FEMALE',
                'contact_no' => '09161234124',
                'email' => 'hezzel@dev.com',
                'address' => 'P-6, TANGUB CITY',
            ],
            [
                'lname' => 'HIBAYA',
                'fname' => 'NIMCHIE',
                'mname' => '',
                'suffix' => '',
                'sex' => 'FEMALE',
                'contact_no' => '09161234123',
                'email' => 'nimchie@dev.com',
                'address' => 'P-6, TANGUB CITY',
            ],
        ];

        \App\Models\Dentist::insertOrIgnore($data);

    }

}
