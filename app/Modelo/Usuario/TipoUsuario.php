<?php

namespace App\Modelo\Usuario;

use Illuminate\Database\Eloquent\Model;

class TipoUsuario extends Model
{
	
    public function users()
    {
    	return $this->hasMany('App\Modelo\Usuario\Usuario');
    }
}
