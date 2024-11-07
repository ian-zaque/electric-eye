<?php

use Illuminate\Database\Seeder;
use App\EmergencyParameter;

class EmergencyParameterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!EmergencyParameter::first()){
            $emergency = new EmergencyParameter();
            $emergency->emergency_id = 1;
            $emergency->name = 'Temperature';
            $emergency->value = 64.7;
            $emergency->save();

            $emergency = new EmergencyParameter();
            $emergency->emergency_id = 2;
            $emergency->name = 'Gas Concentration';
            $emergency->value = 250.8;
            $emergency->save();

            $emergency = new EmergencyParameter();
            $emergency->emergency_id = 3;
            $emergency->name = 'Water Level';
            $emergency->value = 2.5;
            $emergency->save();

            $emergency = new EmergencyParameter();
            $emergency->emergency_id = 4;
            $emergency->name = 'Radiation Level';
            $emergency->value = 10.4;
            $emergency->save();
        }
    }
}
