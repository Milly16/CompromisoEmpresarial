<?php

namespace App\Modelo\Ubigeo;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
	public $timestamps = false;
	
    public function departamento()
    {
    	return $this->belongsTo('App\Modelo\Ubigeo\Departamento', 'departamento_id');
    }

    public function distritos()
    {
    	return $this->hasMany('App\Modelo\Ubigeo\Distrito');
    }
}
