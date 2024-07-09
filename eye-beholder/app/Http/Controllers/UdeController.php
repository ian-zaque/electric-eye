<?php

namespace App\Http\Controllers;

use App\Ude;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UdeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Ude::with(['ude_class', 'interest_zone', 'interest_zone.region'])->get());
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
            'interest_zone_id' => 'required|integer',
            'class_id' => 'required|integer',
            "name" => 'required|string|max:1000|min:2', 
            "mac_id" => 'required|string|max:17|min:17',     // XX:XX:XX:XX:XX:XX
            "latitude" => 'required|numeric',
            "longitude" => 'required|numeric',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $udeData = $request->all();
            $ude = new Ude();
            $ude->fill($udeData)->save();
            $ude = Ude::with(['ude_class', 'interest_zone','interest_zone.region'])->find($ude->id);
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
        $validator = Validator::make($request->all(), [
            'interest_zone_id' => 'required|integer',
            'class_id' => 'required|integer',
            "name" => 'required|string|max:1000|min:2', 
            "mac_id" => 'required|string|max:17|min:17',     // XX:XX:XX:XX:XX:XX
            "latitude" => 'required|numeric',
            "longitude" => 'required|numeric',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $udeData = $request->all();
            $ude->update($udeData);
            $ude->save();
            $ude = Ude::with(['ude_class', 'interest_zone', 'interest_zone.region'])->find($ude->id);
            return response()->json($ude, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ude  $ude
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ude $ude)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ude  $ude
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ude $ude)
    {
        //
    }
}
