<?php

use App\UdeClass;
use Illuminate\Database\Seeder;

class UDEClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!UdeClass::first()){
            $ude_class = new UdeClass();
            $ude_class->class = "BPC";
            $ude_class->save();

            $ude_class = new UdeClass();
            $ude_class->class = "MPC";
            $ude_class->save();

            $ude_class = new UdeClass();
            $ude_class->class = "APC";
            $ude_class->save();
        }
    }
}
