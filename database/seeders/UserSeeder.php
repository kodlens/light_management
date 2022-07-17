<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
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
                'username' => 'admin',
                'lname' => 'Villafuerte',
                'fname' => 'Archielin',
                'mname' => 'P',
                'sex' => 'FEMALE',
                'email' => 'archielin@light.com',
                'contact_no' => '09164578599',
                'role' => 'ADMINISTRATOR',
                'group_role_id' => 1,
                'password' => Hash::make('a')
            ],


            [
                'username' => 'prelyn',
                'lname' => 'Suco',
                'fname' => 'Prelyn ',
                'mname' => 'P',
                'sex' => 'FEMALE',
                'email' => 'prelyn@light.com',
                'contact_no' => '09164578591',
                'role' => 'ADMINISTRATOR',
                'group_role_id' => 2,
                'password' => Hash::make('a')
            ],

            [
                'username' => 'jean',
                'lname' => 'Superales',
                'fname' => 'Jean  ',
                'mname' => 'C',
                'sex' => 'FEMALE',
                'email' => 'jean@light.com',
                'contact_no' => '09164578592',
                'role' => 'STAFF',
                'group_role_id' => 2,
                'password' => Hash::make('a')
            ],
            
        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
