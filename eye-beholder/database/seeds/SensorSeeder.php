<?php

use Illuminate\Database\Seeder;
use App\Sensor;

class SensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Sensor::first()){
            $sensor = new Sensor();
            $sensor->type_sensor_id = 1;
            $sensor->model = 'TS-808';
            $sensor->description = 'Sensor de Temperatura';
            $sensor->save();

            $sensor = new Sensor();
            $sensor->type_sensor_id = 2;
            $sensor->model = 'GS-6505';
            $sensor->description = 'Sensor de gás CO2';
            $sensor->save();

            $sensor = new Sensor();
            $sensor->type_sensor_id = 3;
            $sensor->model = 'WL-5150';
            $sensor->description = 'Sensor de nível de água';
            $sensor->save();

            $sensor = new Sensor();
            $sensor->type_sensor_id = 4;
            $sensor->model = 'RL-5153';
            $sensor->description = 'Sensor de radiação';
            $sensor->save();
        }
    }
}
