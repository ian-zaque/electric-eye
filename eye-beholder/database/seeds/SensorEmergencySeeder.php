<?php

use Illuminate\Database\Seeder;
use App\SensorEmergency;

class SensorEmergencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!SensorEmergency::first()){
            $sensor_emergency = new SensorEmergency();
            $sensor_emergency->emergency_id = 1;
            $sensor_emergency->sensor_id = 1;
            $sensor_emergency->save();

            $sensor_emergency = new SensorEmergency();
            $sensor_emergency->emergency_id = 2;
            $sensor_emergency->sensor_id = 2;
            $sensor_emergency->save();

            $sensor_emergency = new SensorEmergency();
            $sensor_emergency->emergency_id = 3;
            $sensor_emergency->sensor_id = 3;
            $sensor_emergency->save();

            $sensor_emergency = new SensorEmergency();
            $sensor_emergency->emergency_id = 4;
            $sensor_emergency->sensor_id = 4;
            $sensor_emergency->save();
        }
    }
}
