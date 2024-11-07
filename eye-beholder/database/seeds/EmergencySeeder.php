<?php

use Illuminate\Database\Seeder;
use App\Emergency;

class EmergencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Emergency::first()){
            $emergency = new Emergency();
            $emergency->interest_zone_id = 1;
            $emergency->name = 'Incêndio';
            $emergency->description = 'Temperaturas máximas excedidas e focos de incêncio!!';
            $emergency->save();

            $emergency = new Emergency();
            $emergency->interest_zone_id = 2;
            $emergency->name = 'Vazamento de gás';
            $emergency->description = 'Gás monóxido de carbono encontrado!!';
            $emergency->save();

            $emergency = new Emergency();
            $emergency->interest_zone_id = 3;
            $emergency->name = 'Alagamento';
            $emergency->description = 'Ruas alagadas, nível de água subiu!!';
            $emergency->save();

            $emergency = new Emergency();
            $emergency->interest_zone_id = 4;
            $emergency->name = 'Vazamento radioativo';
            $emergency->description = 'Detectado material radioativo!!';
            $emergency->save();
        }
    }
}
