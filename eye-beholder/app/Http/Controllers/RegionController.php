<?php

namespace App\Http\Controllers;

use App\Region;
use App\InterestZone;
use App\Ude;
use App\UdeSensor;
use App\Sensor;
use App\EmergencyParameter;
use App\Emergency;
use App\SensorEmergency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Region::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $regionData = $request->all();
            $region = new Region();
            $region->fill($regionData)->save();
            $region = Region::find($region->id);
            return response()->json($region, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit(Region $region)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Region $region)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $regionData = $request->all();
            $region->update($regionData);
            $region->save();
            $region = Region::find($region->id);
            return response()->json($region, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Region $region)
    {
        $ids_interest_zones = InterestZone::where('region_id', '=', $region->id)->pluck('id');
        $ids_emergencies = Emergency::whereIn('interest_zone_id', $ids_interest_zones)->pluck('id');
        $ids_udes = Ude::whereIn('interest_zone_id', $ids_emergencies)->pluck('id');
        $ids_sensors = SensorEmergency::whereIn('emergency_id', $ids_emergencies)->pluck('sensor_id');

        EmergencyParameter::whereIn('emergency_id', $ids_emergencies)->delete();
        SensorEmergency::whereIn('emergency_id', $ids_emergencies)->delete();
        UdeSensor::whereIn('ude_id', $ids_udes)->delete();
        
        Emergency::whereIn('id', $ids_emergencies)->delete();
        Ude::whereIn('id', $ids_udes)->delete();
        Sensor::whereIn('id', $ids_sensors)->delete();
        InterestZone::whereIn('id', $ids_interest_zones)->delete();

        $region->delete();
        return response()->json(['message' => 'Região deletada com sucesso.'], 200);
    }
}
