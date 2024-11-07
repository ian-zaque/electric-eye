<?php

use Illuminate\Database\Seeder;
use App\TypeSensor;

class TypeSensorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!TypeSensor::first()){
            $type_sensor = new TypeSensor();
            $type_sensor->type = 'Temperature';
            $type_sensor->unit = 'ºC';
            $type_sensor->description = 'Temperatura em graus celsius';
            $type_sensor->save();

            $type_sensor = new TypeSensor();
            $type_sensor->type = 'Gas Concentration';
            $type_sensor->unit = 'ppm';
            $type_sensor->description = 'Concentração de gás em ppm';
            $type_sensor->save();

            $type_sensor = new TypeSensor();
            $type_sensor->type = 'Water Level';
            $type_sensor->unit = 'm^3';
            $type_sensor->description = 'Nível de água em determinado lago';
            $type_sensor->save();

            $type_sensor = new TypeSensor();
            $type_sensor->type = 'Radiation Level';
            $type_sensor->unit = 'Bq';
            $type_sensor->description = 'Nível de radiação medida';
            $type_sensor->save();
        }
    }
}
