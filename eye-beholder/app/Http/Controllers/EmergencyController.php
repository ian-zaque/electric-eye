<?php

namespace App\Http\Controllers;

use App\Emergency;
use App\EmergencyParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmergencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Emergency::with(['emergency_parameters', 'interest_zone', 'interest_zone.region'])->get());
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
            "interest_zone_id" => "required|integer",
            "name" => "required|string|max:1000|min:2", 
            "description" => "required|string|min:2|max:5000",
            "emergency_parameters.*.name" => "required|distinct|string|min:2|max:100",
            "emergency_parameters.*.value" => "required|numeric",
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $emergencyData = $request->all();
            $emergency = new Emergency();
            $emergency->fill($emergencyData)->save();

            $emergency_parameters = $request->all()['emergency_parameters'];
            foreach ($emergency_parameters as $param) {
                $param['emergency_id'] = $emergency->id;
                $emergency_param = new EmergencyParameter();
                $emergency_param->fill($param)->save();
            }

            $emergency = Emergency::with(['emergency_parameters', 'interest_zone', 'interest_zone.region'])->find($emergency->id);
            return response()->json($emergency, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function show(Emergency $emergency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function edit(Emergency $emergency)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Emergency $emergency)
    {
        $validator = Validator::make($request->all(), [
            "interest_zone_id" => "required|integer",
            "name" => "required|string|max:1000|min:2", 
            "description" => "required|string|min:2|max:5000",
            "emergency_parameters.*.name" => "required|distinct|string|min:2|max:100",
            "emergency_parameters.*.value" => "required|numeric",
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $emergencyData = $request->all();
            $emergency->update($emergencyData);
            $emergency->save();

            $emergency_parameters = $request->all()['emergency_parameters'];
            foreach ($emergency_parameters as $param) {
                if(isset($param['id'])){
                    $emergency_param = EmergencyParameter::find($param['id']);
                    $emergency_param->update($param);
                    $emergency_param->save();
                }
                else{
                    $param['emergency_id'] = $emergency->id;
                    $emergency_param = new EmergencyParameter();
                    $emergency_param->fill($param)->save();
                }
            }

            $emergency = Emergency::with(['emergency_parameters', 'interest_zone', 'interest_zone.region'])->find($emergency->id);
            return response()->json($emergency, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Emergency  $emergency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Emergency $emergency)
    {
        EmergencyParameter::where('emergency_id','=',$emergency->id)->delete();
        $emergency->delete();
        return response()->json($emergency, 200);
    }
}
