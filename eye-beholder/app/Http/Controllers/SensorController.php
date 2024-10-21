<?php

namespace App\Http\Controllers;

use App\Sensor;
use App\SensorEmergency;
use App\Emergency;
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
    public function create(){
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

        $validator->sometimes('emergencies.*','required|',function($request){ 
            return sizeof($request->emergencies) > 0;
        });

        $emergencies = collect($request->emergencies)->map(function($item, $key){
            return $item['id'];
        });

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $sensorData = $request->all();
            $sensor = new Sensor();
            $sensor->fill($sensorData)->save();

            $emergencies->each(function($item, $key) use ($sensor) {
                $data = [
                    'sensor_id' => $sensor->id,
                    'emergency_id' => $item,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $sensor_emergency = new SensorEmergency();
                $sensor_emergency->fill($data)->save();
            });

            $sensor = Sensor::with(['type_sensor', 'emergencies'])->find($sensor->id);
            return response()->json($sensor, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function show(Sensor $sensor){
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sensor  $sensor
     * @return \Illuminate\Http\Response
     */
    public function edit(Sensor $sensor){
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

        $request_emergencies = collect($request->emergencies)->map(function($item, $key){
            return $item['id'];
        });

        $validator->sometimes('emergencies.*','required',function($request){ 
            return sizeof($request->emergencies) > 0;
        });

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $sensorData = $request->all();
            $sensor->update($sensorData);
            $sensor->save();

            $present_sensors_emergencies = collect($sensor->emergencies)->map(function($item, $key){
                return $item['id'];
            });

            $save_emergencies = collect($request_emergencies)->diff($present_sensors_emergencies);                 // NEW ONES
            $remove_emergencies = collect($present_sensors_emergencies)->diff($request_emergencies);               // REMOVE THESE
            // $intersect_emergencies = collect($present_sensors_emergencies)->intersect($request_emergencies);    // KEEP THOSE -> DO NOTHING
            // dd($request_emergencies, $save_emergencies, $remove_emergencies, $intersect_emergencies, $present_sensors_emergencies);

            // NEW SENSOR EMERGENCIES
            // MUST BE SAVED CUZ THEY ARE BEING ADDED TO THE EMERGENCIES RELATION
            if(sizeof($save_emergencies) > 0){
                $save_emergencies->each(function($item, $key) use ($sensor) {
                    $data = [
                        'sensor_id' => $sensor->id,
                        'emergency_id' => $item,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
    
                    $sensor_emergency = new SensorEmergency();
                    $sensor_emergency->fill($data)->save();
                });
            }

            // REMOVE SENSOR EMERGENCIES
            // MUST BE REMOVED CUZ THEY WERE DELETED TO THE EMERGENCIES RELATION
            if(sizeof($remove_emergencies) > 0){
                $remove_emergencies->each(function($item, $key) use ($sensor) {
                    $sensor_emergency = SensorEmergency::where('sensor_id', '=', $sensor->id)->where('emergency_id', '=', $item)->delete();
                });
            }

            $sensor = Sensor::with(['type_sensor', 'emergencies'])->find($sensor->id);
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
