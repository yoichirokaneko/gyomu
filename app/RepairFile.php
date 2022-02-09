<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepairFile extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function activity_history(){
		return $this->belongsTo('App\ActivityHisotry');
	}
}
