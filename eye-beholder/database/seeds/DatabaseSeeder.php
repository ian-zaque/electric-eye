<?php

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
        // $this->call(UsersTableSeeder::class);
        $this->call([
            UserRoleSeeder::class,
            UserRoleActionSeeder::class,
            UserSeeder::class,
            UDEClassSeeder::class,
            MqttTopicSeeder::class,
            RegionSeeder::class,
            InterestZoneSeeder::class,
            UdeSeeder::class,  //milene
        ]);
    }
}
