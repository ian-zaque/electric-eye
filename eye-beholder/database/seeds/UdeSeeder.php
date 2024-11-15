<?php

use Illuminate\Database\Seeder;
use App\Ude;

class UdeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        if(!Ude::first()){
            $ude = new Ude();
            $ude->class_id = 1;
            $ude->interest_zone_id = 1;
            $ude->name = 'UDE-1 Cidade Nova';           // Feirinha da Cidade Nova
            $ude->mac_id = '46:0A:CE:E4:E3:18';
            $ude->latitude = '-12.22451';
            $ude->longitude = '-38.96423';
            $ude->save();

            $ude = new Ude();
            $ude->class_id = 2;
            $ude->interest_zone_id = 2;
            $ude->name = 'UDE-2 Sim';                   // Shopping Avenida        
            $ude->mac_id = '3A:6B:A4:C2:19:3B';
            $ude->latitude = '-12.25577';
            $ude->longitude = '-38.92097';
            $ude->save();

            $ude = new Ude(); 
            $ude->class_id = 3;
            $ude->interest_zone_id = 3;
            $ude->name = 'UDE-3 Tomba';                 // Caixa dagua do Tomba
            $ude->mac_id = 'A8:DB:21:6F:7F:7F';
            $ude->latitude = '-12.28720';
            $ude->longitude = '-38.95764';
            $ude->save();

            $ude = new Ude();
            $ude->class_id = 2;
            $ude->interest_zone_id = 4;
            $ude->name = 'UDE-4 Sobradinho';            // Joia da Princesa (estadio)
            $ude->mac_id = '92:C7:7C:E8:4A:E4';
            $ude->latitude = '-12.24351';
            $ude->longitude = '-38.97292';
            $ude->save();
        }

    }
}
