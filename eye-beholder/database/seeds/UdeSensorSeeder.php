<?php

use Illuminate\Database\Seeder;
use App\UdeSensor;

class UdeSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!UdeSensor::first()){
            $ude_sensor = new UdeSensor();
            $ude_sensor->ude_id = 1;
            $ude_sensor->sensor_id = 1;
            $ude_sensor->save();

            $ude_sensor = new UdeSensor();
            $ude_sensor->ude_id = 2;
            $ude_sensor->sensor_id = 2;
            $ude_sensor->save();

            $ude_sensor = new UdeSensor();
            $ude_sensor->ude_id = 3;
            $ude_sensor->sensor_id = 3;
            $ude_sensor->save();

            $ude_sensor = new UdeSensor();
            $ude_sensor->ude_id = 4;
            $ude_sensor->sensor_id = 4;
            $ude_sensor->save();
        }
    }
}
