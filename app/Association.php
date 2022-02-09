<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function clients(){
		return $this->belongsToMany('App\Client')->withTimestamps();
	}

}
