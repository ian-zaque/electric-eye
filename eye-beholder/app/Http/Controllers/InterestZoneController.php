<?php

namespace App\Http\Controllers;

use App\InterestZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InterestZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(InterestZone::with(['region'])->get());
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
            'region_id' => 'required|integer',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $interestZoneData = $request->all();
            $interestZone = new InterestZone();
            $interestZone->fill($interestZoneData)->save();
            $interestZone = InterestZone::with(['region'])->find($interestZone->id);
            return response()->json($interestZone, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InterestZone  $interestZone
     * @return \Illuminate\Http\Response
     */
    public function show(InterestZone $interestZone)
    {
        return response()->json($interestZone);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InterestZone  $interestZone
     * @return \Illuminate\Http\Response
     */
    public function edit(InterestZone $interestZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InterestZone  $interestZone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InterestZone $interestZone)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'description' => 'required|max:1000',
            'region_id' => 'required|integer',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $interestZoneData = $request->all();
            $interestZone->update($interestZoneData);
            $interestZone->save();
            $interestZone = InterestZone::with(['region'])->find($interestZone->id);
            return response()->json($interestZone, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InterestZone  $interestZone
     * @return \Illuminate\Http\Response
     */
    public function destroy(InterestZone $interestZone)
    {
        //
    }
}
