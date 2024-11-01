<?php

use Illuminate\Database\Seeder;
use App\InterestZone;

class InterestZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!InterestZone::first()){
            $interest_zone = new InterestZone();
            $interest_zone->region_id = 1;
            $interest_zone->name = 'Cidade Nova';
            $interest_zone->description = 'Bairo Cidade Nova em FSA';
            $interest_zone->save();

            $interest_zone = new InterestZone();
            $interest_zone->region_id = 2;
            $interest_zone->name = 'SIM';
            $interest_zone->description = 'Bairo SIM em FSA';
            $interest_zone->save();

            $interest_zone = new InterestZone();
            $interest_zone->region_id = 3;
            $interest_zone->name = 'Tomba';
            $interest_zone->description = 'Bairo Tomba em FSA';
            $interest_zone->save();

            $interest_zone = new InterestZone();
            $interest_zone->region_id = 4;
            $interest_zone->name = 'Sobradinho';
            $interest_zone->description = 'Bairo Sobradinho em FSA';
            $interest_zone->save();
        }

    }
}
