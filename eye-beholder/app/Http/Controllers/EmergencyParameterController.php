<?php

namespace App\Http\Controllers;

use App\EmergencyParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmergencyParameterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(EmergencyParameter::with(['emergency'])->get());
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
            'emergency_id' => 'required|integer',
            "name" => 'required|string|max:1000|min:2', 
            "value" => 'required|numeric',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $emergencyData = $request->all();
            $emergency = new EmergencyParameter();
            $emergency->fill($emergencyData)->save();
            $emergency = EmergencyParameter::with(['emergency'])->find($emergency->id);
            return response()->json($emergency, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmergencyParameter  $emergencyParameter
     * @return \Illuminate\Http\Response
     */
    public function show(EmergencyParameter $emergencyParameter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmergencyParameter  $emergencyParameter
     * @return \Illuminate\Http\Response
     */
    public function edit(EmergencyParameter $emergencyParameter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmergencyParameter  $emergencyParameter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EmergencyParameter $emergencyParameter)
    {
        $validator = Validator::make($request->all(), [
            'emergency_id' => 'required|integer',
            "name" => 'required|string|max:1000|min:2', 
            "value" => 'required|numeric',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $emergencyData = $request->all();
            $emergency->update($emergencyData);
            $emergency->save();
            $emergency = EmergencyParameter::with(['emergency'])->find($emergency->id);
            return response()->json($emergency, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmergencyParameter  $emergencyParameter
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmergencyParameter $emergencyParameter)
    {
        //
    }
}
