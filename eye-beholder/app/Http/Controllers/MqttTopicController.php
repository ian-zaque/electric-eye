<?php

namespace App\Http\Controllers;

use App\MqttTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'topic' => 'required|distinct|min:2|max:100',
            'description' => 'required|min:3|max:1000',
            'active' => 'required|boolean',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $topicData = $request->all();
            $topic = new MqttTopic();
            $topic->fill($topicData)->save();
            $topic = MqttTopic::find($topic->id);
            return response()->json($topic, 200);
        }
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
        $validator = Validator::make($request->all(), [
            'topic' => 'required|distinct|min:2|max:100',
            'description' => 'required|min:3|max:1000',
            'active' => 'required|boolean',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $topicData = $request->all();
            $mqttTopic->update($topicData);
            $mqttTopic->save();
            $mqttTopic = MqttTopic::find($mqttTopic->id);
            return response()->json($mqttTopic, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MqttTopic  $mqttTopic
     * @return \Illuminate\Http\Response
     */
    public function destroy(MqttTopic $mqttTopic)
    {
        $mqttTopic->delete();
        return response()->json(['message' => 'Tópico MQTT deletado com sucesso.'], 200);
    }
}
