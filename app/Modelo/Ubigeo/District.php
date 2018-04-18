<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = false;

    public function provincia()
    {
    	return $this->belongsTo('App\Province', 'province_id');
    }

    public function empresas()
    {
    	return $this->hasMany('App\Company');
    }

     public function requerimientos()
    {
    	return $this->hasMany('App\GenRequest');
    }
}
