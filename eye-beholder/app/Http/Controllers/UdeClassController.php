<?php

namespace App\Http\Controllers;

use App\UdeClass;
use Illuminate\Http\Request;

class UdeClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(UdeClass::get());
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
            "class" => 'required|string|max:1000|min:3', 
            "fullname" => 'required|string|max:1000|min:3',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $udeClassData = $request->all();
            $udeClass = new UdeClass();
            $udeClass->fill($udeClassData)->save();
            $udeClass = UdeClass::find($udeClass->id);
            return response()->json($udeClass, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UdeClass  $udeClass
     * @return \Illuminate\Http\Response
     */
    public function show(UdeClass $udeClass)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UdeClass  $udeClass
     * @return \Illuminate\Http\Response
     */
    public function edit(UdeClass $udeClass)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UdeClass  $udeClass
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UdeClass $udeClass)
    {
        $validator = Validator::make($request->all(), [
            "class" => 'required|string|max:1000|min:3', 
            "fullname" => 'required|string|max:1000|min:3',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $udeClassData = $request->all();
            $udeClass->update($udeClassData);
            $udeClass->save();
            $udeClass = UdeClass::find($udeClass->id);
            return response()->json($udeClass, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UdeClass  $udeClass
     * @return \Illuminate\Http\Response
     */
    public function destroy(UdeClass $udeClass)
    {
        //
    }
}
