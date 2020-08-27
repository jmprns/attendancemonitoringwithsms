<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Event;
use App\Attendance;

class EventController extends Controller
{
	public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
    	$events = Event::all();
    	return view('attendance.events')->with('events', $events);
    }

    public function store(Request $request)
    {
    	//Requiring all fields
        $request->validate([
            'name' => 'required',
            'startDate' => 'required',
            'startTime' => 'required',
            'endDate' => 'required',
            'endTime' => 'required'
        ]);

        //fetching the event form data
        $eventName = $request->name;
        $startDate = $request->startDate;
        $startTime = $request->startTime;
        $endDate = $request->endDate;
        $endTime = $request->endTime;

        //Converting Start Date-time to Start Timestamp
        $s1 = $request->startDate."T".$request->startTime;
        $start = strtotime($s1);

        //Converting End Date-time to End Timestamp
        $e1 = $request->endDate."T".$request->endTime;
        $end = strtotime($e1);

        if($start > $end){
            return response()->json([
                'message' => 'Invalid date/time range'
            ], 406);
        }

        //Inserting to Database
        Event::create([
            "name" => $eventName,
            "start" => $start,
            "end" => $end
        ]);

        return response()->json([
                'message' => 'Event has been added'
            ], 200);
    }

    public function update(Request $request)
    {
        //Requiring all fields
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            'startDate' => 'required',
            'startTime' => 'required',
            'endDate' => 'required',
            'endTime' => 'required'
        ]);

        // Finding the event
        $event = Event::find($request->id);

        if(!$event){
            return response()->json([
                'message' => 'Event not found!'
            ], 406);
        }

        //fetching the event form data
        $eventName = $request->name;
        $startDate = $request->startDate;
        $startTime = $request->startTime;
        $endDate = $request->endDate;
        $endTime = $request->endTime;

        //Converting Start Date-time to Start Timestamp
        $s1 = $request->startDate."T".$request->startTime;
        $start = strtotime($s1);

        //Converting End Date-time to End Timestamp
        $e1 = $request->endDate."T".$request->endTime;
        $end = strtotime($e1);

        if($start > $end){
            return response()->json([
                'message' => 'Invalid date/time range'
            ], 406);
        }

        // Updating the event;
        $event->name = $request->name;
        $event->start = $start;
        $event->end = $end;
        $event->save();

        return response()->json([
                'message' => 'Event has been updated.'
            ], 200);



    }

    public function show($id)
    {

    	$event = Event::find($id);

    	$attendance = Attendance::with('student.year.department')->where('type', $event->id)->get();

    	if(!$event){
            return abort(404);
        }

    	return view('attendance.show')->with('event', $event)->with('attendance', $attendance);
    }

    public function destroy($id)
    {
        $event = Event::find($id);

        if(!$event){
            return abort(500);
        }

        $att = Attendance::where('type', $event->id)->delete();

        $event->delete();

        return redirect('/attendance/events');
    }
}
