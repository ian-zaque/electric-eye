<?php

namespace App\Http\Controllers;

use App\Ude;
use App\UdeSensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\MqttPublisherService;

class UdeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Ude::with(['ude_class', 'sensors', 'interest_zone', 'interest_zone.region'])->get());
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
    public function store(Request $request, MqttPublisherService $mqtt_publisher_service)
    {
        $validator = Validator::make($request->all(), [
            'interest_zone_id' => 'required|integer',
            'class_id' => 'required|integer',
            "name" => 'required|string|max:1000|min:2', 
            "mac_id" => 'required|string|max:17|min:17|unique:udes,mac_id',     // XX:XX:XX:XX:XX:XX
            "latitude" => 'required|numeric',
            "longitude" => 'required|numeric',
        ]);

        $validator->sometimes('sensors.*','required|',function($request){ 
            return sizeof($request->sensors) > 0;
        });

        $sensors = collect($request->sensors)->map(function($item, $key){
            return $item['id'];
        });

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $udeData = $request->all();
            $ude = new Ude();
            $ude->fill($udeData)->save();

            $sensors->each(function($item, $key) use ($ude) {
                $data = [
                    'ude_id' => $ude->id,
                    'sensor_id' => $item,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                $ude_sensor = new UdeSensor();
                $ude_sensor->fill($data)->save();
            });

            $ude = Ude::with(['ude_class', 'sensors', 'interest_zone','interest_zone.region'])->find($ude->id);

            $mqtt_publisher_service->subscribeUde($ude->mac_id);

            return response()->json($ude, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ude  $ude
     * @return \Illuminate\Http\Response
     */
    public function show(Ude $ude)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ude  $ude
     * @return \Illuminate\Http\Response
     */
    public function edit(Ude $ude)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ude  $ude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ude $ude, MqttPublisherService $mqtt_publisher_service)
    {
        $validator = Validator::make($request->all(), [
            'interest_zone_id' => 'required|integer',
            'class_id' => 'required|integer',
            "name" => 'required|string|max:1000|min:2', 
            "mac_id" => 'required|string|max:17|min:17|unique:App\Ude,mac_id,' . $ude->id,     // XX:XX:XX:XX:XX:XX
            "latitude" => 'required|numeric',
            "longitude" => 'required|numeric',
        ]);

        $validator->sometimes('sensors.*','required|',function($request){ 
            return sizeof($request->sensors) > 0;
        });

        $request_sensors = collect($request->sensors)->map(function($item, $key){
            return $item['id'];
        });

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $udeData = $request->all();
            $ude->update($udeData);
            $ude->save();

            $present_udes_sensors = collect($ude->sensors)->map(function($item, $key){
                return $item['id'];
            });

            $save_sensors = collect($request_sensors)->diff($present_udes_sensors);                 // NEW ONES
            $remove_sensors = collect($present_udes_sensors)->diff($request_sensors);               // REMOVE THESE
            // $intersect_emergencies = collect($present_udes_sensors)->intersect($request_sensors);    // KEEP THOSE -> DO NOTHING
            // dd($request_sensors, $save_sensors, $remove_sensors, $intersect_emergencies, $present_udes_sensors);

            // NEW SENSOR EMERGENCIES
            // MUST BE SAVED CUZ THEY ARE BEING ADDED TO THE EMERGENCIES RELATION
            if(sizeof($save_sensors) > 0){
                $save_sensors->each(function($item, $key) use ($ude) {
                    $data = [
                        'ude_id' => $ude->id,
                        'sensor_id' => $item,
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
    
                    $ude_sensor = new UdeSensor();
                    $ude_sensor->fill($data)->save();
                });
            }

            // REMOVE SENSOR EMERGENCIES
            // MUST BE REMOVED CUZ THEY WERE DELETED TO THE EMERGENCIES RELATION
            if(sizeof($remove_sensors) > 0){
                $remove_sensors->each(function($item, $key) use ($ude) {
                    $ude_sensor = UdeSensor::where('ude_id', '=', $ude->id)->where('sensor_id', '=', $item)->delete();
                });
            }

            $ude = Ude::with(['ude_class', 'sensors', 'interest_zone', 'interest_zone.region'])->find($ude->id);

            $mqtt_publisher_service->subscribeUde($ude->mac_id);

            return response()->json($ude, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ude  $ude
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ude $ude)
    {
        UdeSensor::where('ude_id', '=', $ude->id)->delete();                        // ligação entre sensor e ude
        $ude->delete();
        return response()->json(['message' => 'UDE deletada com sucesso.'], 200);
    }
}
