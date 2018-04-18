<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $timestamps = false;

    public function distritos()
    {
    	return $this->hasMany('App\District');
    }

    public function departamento()
    {
    	return $this->belongsTo('App\Department', 'department_id');
    }
}
