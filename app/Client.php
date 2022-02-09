<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function pics(){
		return $this->hasMany('App\Pic');
	}

    // たぶん多対多
    public function associations(){
		return $this->belongsToMany('App\Association')->withTimestamps();
	}

    public function actual_models(){
		return $this->hasMany('App\ActualModel');
	}

    public function client_files(){
		return $this->hasMany('App\ClientFile');
	}

    public function activity_histories(){
		return $this->hasMany('App\ActivityHistory');
	}

    public function properties(){
		return $this->hasMany('App\Property');
	}
}
