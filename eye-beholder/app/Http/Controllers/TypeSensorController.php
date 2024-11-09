<?php

namespace App\Http\Controllers;

use App\TypeSensor;
use App\Sensor;
use App\SensorEmergency;
use App\UdeSensor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TypeSensorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(TypeSensor::all());
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
            'type' => 'required|distinct|min:2|max:100',
            'unit' => 'required|min:2|max:100',
            'description' => 'required|min:3|max:1000',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $typeData = $request->all();
            $type = new TypeSensor();
            $type->fill($typeData)->save();
            $type = TypeSensor::find($type->id);
            return response()->json($type, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TypeSensor  $typeSensor
     * @return \Illuminate\Http\Response
     */
    public function show(TypeSensor $typeSensor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TypeSensor  $typeSensor
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeSensor $typeSensor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TypeSensor  $typeSensor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeSensor $typeSensor)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required|distinct|min:2|max:100',
            'unit' => 'required|min:2|max:100',
            'description' => 'required|min:3|max:1000',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $typeData = $request->all();
            $typeSensor->update($typeData);
            $typeSensor->save();
            $typeSensor = TypeSensor::find($typeSensor->id);
            return response()->json($typeSensor, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TypeSensor  $typeSensor
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeSensor $typeSensor)
    {
        // Obtém os IDs dos sensores do tipo especificado
        $ids_sensors = Sensor::where('type_sensor_id', $typeSensor->id)->pluck('id');

        // Deleta os registros relacionados em lote para evitar múltiplas queries
        UdeSensor::whereIn('sensor_id', $ids_sensors)->delete();                        // ligação entre sensor e ude
        SensorEmergency::whereIn('sensor_id', $ids_sensors)->delete();                  // ligação entre sensor e emergências
        Sensor::whereIn('id', $ids_sensors)->delete();

        // Deleta o tipo de sensor
        $typeSensor->delete();

        // Retorna resposta JSON de sucesso
        return response()->json(['message' => 'Tipo de sensor e sensores associados deletados com sucesso.'], 200);

    }
}
