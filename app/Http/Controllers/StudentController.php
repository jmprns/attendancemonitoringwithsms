<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Year;
use App\Student;
use App\Attendance;
use File;

class StudentController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = Student::with('year.department')->get();

        return view('student.index')->with('students', $students);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $years = Year::with('department')->get();

        return view('student.register')->with('years', $years);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Validation required field
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'mname' => 'required',
            'num' => 'required',
            'dept' => 'required',
            'rfid' => 'required'
        ]);
        
        // Validating the number
        if(preg_match('/[A-Za-z]/', $request->num)){
            return response()->json([
                'message' => 'Invalid number.'
            ], 406);
        }

        // Validating the department
        if(preg_match('/[A-Za-z]/', $request->dept)){
            return response()->json([
                'message' => 'Invalid department.'
            ], 406);
        }

        // Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return response()->json([
                'message' => 'Invalid image file.'
            ], 406);
        }

        $find = Student::where('rfid', $request->rfid)->get()->count();

        if($find > 0){
            return response()->json([
                'message' => 'RFID is already registered.'
            ], 406);
        }

        if($request->image == ''){

            Student::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mname' => $request->mname,
                'rfid' => $request->rfid,
                'number' => $request->num,
                'year_id' => $request->dept,
                'image' => '00.png'
            ]);

        }else{

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time()."-".str_random(8).".jpg";
            $destination = public_path()."/images/students/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

            Student::create([
                'fname' => $request->fname,
                'lname' => $request->lname,
                'mname' => $request->mname,
                'rfid' => $request->rfid,
                'number' => $request->num,
                'year_id' => $request->dept,
                'image' => $imageName
            ]);


        }

        

        return response()->json([
            'message' => 'success'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $years = Year::with('department')->get();
        $student = Student::find($id);

        return view('student.edit')
                ->with('years', $years)
                ->with('student', $student);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Validation required field
        $request->validate([
            'id' => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'mname' => 'required',
            'num' => 'required',
            'dept' => 'required',
            'rfid' => 'required'
        ]);
        
        // Validating the number
        if(preg_match('/[A-Za-z]/', $request->num)){
            return response()->json([
                'message' => 'Invalid number.'
            ], 406);
        }

        // Validating the department
        if(preg_match('/[A-Za-z]/', $request->dept)){
            return response()->json([
                'message' => 'Invalid department.'
            ], 406);
        }

        // Validating image
        if($request->image == "data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wBDAAEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/2wBDAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQH/wAARCADIAMgDAREAAhEBAxEB/8QAFQABAQAAAAAAAAAAAAAAAAAAAAv/xAAUEAEAAAAAAAAAAAAAAAAAAAAA/8QAFAEBAAAAAAAAAAAAAAAAAAAAAP/EABQRAQAAAAAAAAAAAAAAAAAAAAD/2gAMAwEAAhEDEQA/AJ/4AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP//Z"){
            return response()->json([
                'message' => 'Invalid image file.'
            ], 406);
        }


        $student = Student::find($request->id);

        if(!$student){
            return response()->json([
                'message' => 'Student not found.'
            ], 406);
        }


        $check_rfid = Student::where('rfid', $request->rfid)->get()->first();


        if(!$check_rfid == null){

            if($check_rfid->id != $request->id){
                return response()->json([
                    'message' => 'RFID already registered.'
                ], 406);
            }
            
        }


       

        if($request->image == ''){
            $student->fname = $request->fname;
            $student->lname = $request->lname;
            $student->mname = $request->mname;
            $student->number = $request->num;
            $student->year_id = $request->dept;
            $student->rfid = $request->rfid;
        }else{

            if($student->image !== '00.png'){
                //Deleting the current image
                $image_path = public_path()."/images/students/".$student->image;
                File::delete($image_path);
            }

            //Image Decoding
            $image = $request->image;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time()."-".str_random(8).".jpg";
            $destination = public_path()."/images/students/".$imageName;
            $actualImage = base64_decode($image);
            $move = file_put_contents($destination, $actualImage);

            $student->fname = $request->fname;
            $student->lname = $request->lname;
            $student->mname = $request->mname;
            $student->number = $request->num;
            $student->year_id = $request->dept;
            $student->rfid = $request->rfid;
            $student->image = $imageName;

            
        }

        $student->save();

        return response()->json([
            'message' => 'success'
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $student = Student::find($id);

        if(!$student){
            return abort(404);
        }else{

            if($student->image !== '00.png'){
                //Deleting the current image
                $image_path = public_path()."/images/students/".$student->image;
                File::delete($image_path);
            }

            $student->delete();

            return redirect('/student');
        }

        Attendance::where('student_id', $id)->delete();


    }

    public function delete(Request $request)
    {
        if(!$request->ids){
            return response()->json([
                    'message' => 'Select at least two students!'
            ], 406);
        }

        foreach($request->ids as $id){

            $student = Student::find($id);

            if(!$student){
                return abort(404);
            }else{

                if($student->image !== '00.png'){
                    //Deleting the current image
                    $image_path = public_path()."/images/students/".$student->image;
                    File::delete($image_path);
                }

                $student->delete();

               
            }

            Attendance::where('student_id', $id)->delete();
            
        }

        

        return response()->json([
            'message' => 'Students has been deleted'
        ], 200);
    }
}
