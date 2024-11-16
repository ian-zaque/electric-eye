<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // Data inicial (start_date)
        $start_date = date("Y-m-d H:i:s", time() - 3600 * 48);

        // Data final (end_date)
        $end_date = date("Y-m-d H:i:s", time() + 3600 * 48);

        $events = Event::with(['ude', 'ude.ude_class', 'region'])
            ->when($start_date, function ($b) use ($start_date) { $b->where('timestamp', '>=', $start_date); })
            ->when($end_date, function ($b) use ($end_date) { $b->where('timestamp', '<=', $end_date); })
            ->get();

        return response()->json($events);
    }

    public function getEventsByDate(Request $request)
    {   
        // dd($request->all());
        $dates = json_decode($request->all()['dates']);
        $start_date = $dates->start_date;
        $end_date = $dates->end_date;

        $events = Event::with(['ude', 'ude.ude_class', 'region'])
            ->when($start_date, function ($b) use ($start_date) { $b->where('timestamp', '>=', $start_date); })
            ->when($end_date, function ($b) use ($end_date) { $b->where('timestamp', '<=', $end_date); })
            ->get();

        return response()->json($events);
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
            'ude_id' => 'required|integer',
            'region_id' => 'required|integer',
            'timestamp' => 'required|date',
            'event' => 'required|json',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $eventData = $request->all();
            $event = new Event();
            $event->fill($eventData)->save();
            $event = Event::find($event->id);
            return response()->json($event, 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validator = Validator::make($request->all(), [
            'ude_id' => 'required|integer',
            'region_id' => 'required|integer',
            'timestamp' => 'required|date',
            'event' => 'required|json',
        ]);

        if($validator->fails()){ return response()->json($validator->errors(), 403); }
        else{
            $eventData = $request->all();
            $event->update($eventData);
            $event->save();
            $event = Event::find($event->id);
            return response()->json($event, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        //
    }
}
