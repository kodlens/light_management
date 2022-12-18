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
                'lname' => 'Pradia',
                'fname' => 'Gerliza',
                'mname' => '',
                'sex' => 'FEMALE',
                'email' => 'liz@light.com',
                'contact_no' => '1234567',
                'role' => 'ADMINISTRATOR',
                'group_role_id' => 1,
                'password' => Hash::make('a')
            ],


            [
                'username' => 'liz',
                'lname' => 'Pradia',
                'fname' => 'Gerliza ',
                'mname' => '',
                'sex' => 'FEMALE',
                'email' => 'liz01@light.com',
                'contact_no' => '12312342234123',
                'role' => 'ADMINISTRATOR',
                'group_role_id' => 2,
                'password' => Hash::make('a')
            ],
        ];

        \App\Models\User::insertOrIgnore($data);
    }
}
