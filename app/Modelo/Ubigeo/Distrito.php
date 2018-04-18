<?php

namespace App\Modelo\Ubigeo;

use Illuminate\Database\Eloquent\Model;

class Distrito extends Model
{
	public $timestamps = false;
	
    public function provincia()
    {
    	return $this->belongsTo('App\Modelo\Ubigeo\Provincia', 'provincia_id');
    }

    public function empresas()
    {
    	return $this->hasMany('App\Modelo\Empresa\Empresa');
    }
}
