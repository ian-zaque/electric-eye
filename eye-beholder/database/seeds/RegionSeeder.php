<?php

use Illuminate\Database\Seeder;
use App\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!Region::first()){
            $region = new Region();
            $region->name = 'Região Norte';
            $region->description = 'Região Norte de Feira de Santana';
            $region->save();

            $region = new Region();
            $region->name = 'Região Leste';
            $region->description = 'Região Leste de Feira de Santana';
            $region->save();

            $region = new Region();
            $region->name = 'Região Sul';
            $region->description = 'Região Sul de Feira de Santana';
            $region->save();

            $region = new Region();
            $region->name = 'Região Oeste';
            $region->description = 'Região Oeste de Feira de Santana';
            $region->save();
        }

    }
}
