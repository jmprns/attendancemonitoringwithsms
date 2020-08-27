<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\SMS;

class SMSController extends Controller
{
    public function __construct()
    {
      
    }

    public function count()
    {

        $x = SMS::where('status', 0)->get()->count();


        

        // // if($x != )

        // echo $x;
        // die;

        $messages = SMS::where('status', 0)->get()->take(10);

        $lists = array();

        foreach($messages as $i => $message){
            $lists[$i]['number'] = $message->number;
            $lists[$i]['text'] = $message->message;
            $v = SMS::find($message->id);
            $v->status = 1;
            $v->save();
        }

        $response['count'] = $x;
        $response['lists'] = $lists;
        echo json_encode($response);


        // return response()->json([
        //     'count' => $x,
        //     'lists' => $lists
        // ], 200);

        
    }

    public function server()
    {
        $messages = SMS::where('status', 0)->get();
        // echo json_encode($messages);
        return view('sms.server')->with([
            'messages' => $messages,
            'server' => env('SMS_SERVER')
        ]);
    }

    public function test()
    {

    }
}
