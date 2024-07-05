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
        // return dd(UdeClass::with('udes')->get()->toArray());
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
        //
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
        //
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
