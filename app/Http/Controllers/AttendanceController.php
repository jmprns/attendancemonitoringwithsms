<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Attendance;

class AttendanceController extends Controller
{
    public function __construct()
    {
    	$this->middleware('auth');
    }

    public function index()
    {
        $attendance = Attendance::with('student.year.department')->orderBy('timestamp', 'asc')->get();
    	return view('attendance.regular')->with('attendance', $attendance);
    }

    
    
}
