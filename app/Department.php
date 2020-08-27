<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

	public function year()
	{
		return $this->hasMany('App\Year', 'year_id');
	}
}
