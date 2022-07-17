<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupRoleSeeder extends Seeder
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
                'group_role_name' => 'ADMINISTRATOR',
            ],
            [
                'group_role_name' => 'GUARD',
            ],
            [
                'group_role_name' => 'IT',
            ],
    
            
        ];

        \App\Models\GroupRole::insertOrIgnore($data);


    }
}
