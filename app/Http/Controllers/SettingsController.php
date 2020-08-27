<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Auth;
use Hash;

class SettingsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function profile()
    {
    	return view('settings.profile');
    }

    public function update(Request $request)
    {
    	// Required fields
    	$request->validate([
    		'fname' => 'required',
    		'lname' => 'required'
    	]);


    	$user = User::find(Auth::user()->id);

    	$user->fname = $request->fname;
    	$user->lname = $request->lname;
    	$user->mname = $request->mname;
    	$user->save();

    	return response()->json([
                'message' => 'Complete.'
            ], 200);
    }

    public function password(Request $request)
    {
    	// Required fields
    	$request->validate([
    		'old' => 'required',
    		'new' => 'required'
    	]);

    	if(Hash::check($request->old, Auth::user()->password) == false){
    		return response()->json([
                'message' => 'Wrong password.'
            ], 406);
    	}

    	$user = User::find(Auth::user()->id);
    	$user->password = Hash::make($request->new);
    	$user->save();

    	return response()->json([
                'message' => 'Complete.'
            ], 200);
    }

    public function add()
    {
        $users = User::get();
    	return view('settings.add', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
       // Required fields
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            'pass' => 'required',
            'cpass' => 'required'
        ]);


        if($request->pass !== $request->cpass){
            return response()->json([
                'message' => 'Password mismatch'
            ], 406);
        }

        $check = User::where('email', $request->email)->get()->count();

        if($check > 0){
            return response()->json([
                'message' => 'Email is taken.'
            ], 406);
        }

        User::create([
            'fname' => $request->fname,
            'lname' => $request->lname,
            'mname' => $request->mname,
            'email' => $request->email,
            'password' => Hash::make($request->pass)
        ]);

        return response()->json([
                'message' => 'Complete.'
            ], 200);
    }
}
