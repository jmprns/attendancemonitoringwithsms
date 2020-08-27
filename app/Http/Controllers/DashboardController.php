<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;
use App\Attendance;
use App\Event;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
    public function index()
    {
    	$attendance = Attendance::with('student.year.department')->where('type', 0)->where('date', date('Y-m-d', time()))->orderBy('timestamp', 'asc')->get();

    	$count['student'] = Student::get()->count();
    	$count['present'] = Attendance::where('type', 0)->where('date', date('Y-m-d'))->where('action', 0)->distinct('student_id')->get()->count();
        $count['events'] = Event::get()->count();

    	return view('dashboard')->with('count', $count)->with('attendance', $attendance);
    }
}
