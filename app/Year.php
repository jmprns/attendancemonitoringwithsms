<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $fillable = ['name', 'dept_id'];

    public function department()
    {
    	return $this->belongsTo('App\Department', 'dept_id');
    }
}
