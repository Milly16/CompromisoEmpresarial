<?php

namespace App\Modelo\Ubigeo;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
	public $timestamps = false;

	public function provincias()
    {
    	return $this->hasMany('App\Modelo\Ubigeo\Provincia');
    }
    
}
