<?php

namespace App\Http\Controllers;

use App\MqttTopic;
use Illuminate\Http\Request;

class MqttTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(MqttTopic::all());
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
     * @param  \App\MqttTopic  $mqttTopic
     * @return \Illuminate\Http\Response
     */
    public function show(MqttTopic $mqttTopic)
    {
        return response()->json($mqttTopic);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MqttTopic  $mqttTopic
     * @return \Illuminate\Http\Response
     */
    public function edit(MqttTopic $mqttTopic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MqttTopic  $mqttTopic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MqttTopic $mqttTopic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MqttTopic  $mqttTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(MqttTopic $mqttTopic)
    {
        //
    }
}
