<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = ['student_id', 'timestamp', 'date', 'action', 'type'];

    public function student()
    {
    	return $this->belongsTo('App\Student', 'student_id');
    }
}
