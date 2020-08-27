<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['fname', 'lname', 'mname', 'rfid', 'number', 'year_id', 'image'];
    public function year()
    {
    	return $this->belongsTo('App\Year', 'year_id');
    }
}
