<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function client(){
		return $this->belongsTo('App\Client');
	}

    public function activity_history(){
		return $this->belongsTo('App\ActivityHistory');
	}

    public function sales_staff(){
		return $this->belongsTo('App\SalesStaff');
	}

    public function pic(){
		return $this->hasonethrough('App\Pic', 'App\Client');
	}

    public function estimate_files(){
		return $this->hasMany('App\EstimateFile');
	}

}
