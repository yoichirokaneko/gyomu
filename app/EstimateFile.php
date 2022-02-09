<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstimateFile extends Model
{
    protected $guarded = [
	    'id',
	    'created_at',
		'updated_at',
	];

    public function property(){
		return $this->belongsTo('App\Property');
	}
}
