<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Attendance;
use App\Student;

use App\Event;
use App\SMS;

class ScanController extends Controller
{
    public function regular()
    {
    	return view('scan.regular');
    }

    public function event($id)
    {
        $event = Event::find($id);

        if(!$event){
            return abort(404);
        }

        if($event->end < time()){
            return abort(500);
        }

    	return view('scan.event')->with('event', $event);
    }

    public function scan(Request $request)
    {


    	// Find the subscriber
    	$student = Student::with('year.department')->where('rfid', $request->rfid)->get()->first();

        

    	if(!$student){
    		return response()->json([
                'message' => 'STUDENT NOT FOUND!'
            ], 406);
    	}

    	$date = date('Y-m-d', time());


        // checking last attemp
        $check = Attendance::where('student_id', $student->id)->where('date', $date)->orderby('timestamp', 'desc')->get()->first();

        if($check){
            $date_check = $check->timestamp + 300;
            if($date_check > time()){
                return response()->json([
                    'message' => 'WAIT FOR 15 MINUTES'
                ], 406);
            }
        }

        


    	$evenCount = array('0','2','4','6','8','10','12','14','16','18','20','22','24','26','28','','30','32','34','36','38','40','42','44','46','48','50');
		
    	if($request->event == '0'){

    		$count = Attendance::where('date', $date)->where('student_id', $student->id)->where('type', 0)->get()->count();
            if(in_array($count, $evenCount)){$action = 0;}else{$action = 1;}

            $timestamp = date('Y-m-d h:i:s A', time());

            if($action == 0){
                $actt = 'TIMED IN';
            }else{
                $actt = 'TIMED OUT';
            }

            $message = "
                WESLEYAN UNIVERSITY PHILIPPINES - AURORA \n \n
                {$student->fname} {$student->lname} has been {$actt} {$timestamp} \n \n
                This is a generated text message. Do not reply.
            ";

            SMS::create([
                'number' => $student->number,
                'message' => $message
            ]);
            


    	}else{

    		$count = Attendance::where('date', $date)->where('student_id', $student->id)->where('type', $request->event)->get()->count();
            if(in_array($count, $evenCount)){$action = 0;}else{$action = 1;}

            $timestamp = date('Y-m-d h:i:s A', time());

            if($action == 0){
                $actt = 'TIMED IN';
            }else{
                $actt = 'TIMED OUT';
            }

            $message = "
                WESLEYAN UNIVERSITY PHILIPPINES - AURORA \n \n
                {$student->fname} {$student->lname} has been {$actt} {$timestamp} \n \n
                This is a generated text message. Do not reply.
            ";

            SMS::create([
                'number' => $student->number,
                'message' => $message
            ]);

    	}

    	Attendance::create([
    		'student_id' => $student->id,
    		'timestamp' => time(),
    		'date' => $date,
    		'action' => $action,
    		'type' => $request->event
    	]);


    	if($action == 0){$act = 'TIME IN';}else{$act = 'TIME OUT';}

    	return response()->json([
            'name' => $student->lname.", ".$student->fname." ".$student->mname.".",
            'rfid' => $student->rfid,
            'image' => $student->image,
            'dept' => $student->year->department->name." - ".$student->year->name,
            'date' => date('Y-m-d h:i A', time()),
            'action' => $act
        ], 200);

    }
}
