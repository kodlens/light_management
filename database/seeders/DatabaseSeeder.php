<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
           
            GroupRoleSeeder::class,
            UserSeeder::class,
            BuildingSeeder::class,
            FloorSeeder::class,
            RoomSeeder::class,
            DeviceSeeder::class,
            ScheduleSeeder::class,
            DeviceAccessSeeder::class,
        ]);
    }
}
