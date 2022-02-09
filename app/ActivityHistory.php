<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityHistory extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function client(){
		return $this->belongsTo('App\Client');
	}

    public function pic(){
		return $this->hasonethrough('App\Pic', 'App\Client');
	}

    public function sales_staff(){
		return $this->belongsTo('App\SalesStaff');
	}

    public function properties(){
		return $this->hasMany('App\Property');
	}

    public function repair_files(){
		return $this->hasMany('App\RepairFile');
	}
}
