<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesStaff extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function activity_histories(){
		return $this->hasMany('App\ActivityHistory');
	}

    public function properties(){
		return $this->hasMany('App\Property');
	}

}
