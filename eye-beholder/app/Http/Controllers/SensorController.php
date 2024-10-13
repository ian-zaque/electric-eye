<?php

namespace App\Http\Controllers;

use App\Sensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Sensor::with(['type_sensor', 'emergencies'])->get());
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
            'type_sensor_id' => 'required|integer',
            'model' => 'required|min:2|max:100',
            'description' => 'required|min:3|max:1000',
        ]);

        $validator->sometimes('emergencies.*.sensor_id','required|integer',function($request){ 
            return sizeof($request->emergencies) > 0;
        });

        $validator->sometimes('emergencies.*.emergency_id','required|integer',function($request){ 
            return sizeof($request->emergencies) > 0;
        });

        $emergencies = collect($request->emergencies)->map(function($item, $key){
            // return eu sou uma princesa de humanas <3
            return $item['id'];
        })->toArray();

        dd($emergencies);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $sensorData = $request->all();
            $sensor = new Sensor();
            $sensor->fill($sensorData)->save();
            $sensor = Sensor::with(['type_sensor'])->find($sensor->id);

            dd($request->emergencies);
            
            return response()->json($sensor, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sensor $sensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sensor $sensor)
    {
        $validator = Validator::make($request->all(), [
            'type_sensor_id' => 'required|integer',
            'model' => 'required|min:2|max:100',
            'description' => 'required|min:3|max:1000',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $sensorData = $request->all();
            $sensor->update($sensorData);
            $sensor->save();
            $sensor = Sensor::with(['type_sensor'])->find($sensor->id);
            return response()->json($sensor, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sensor $sensor)
    {
        //
    }
}
