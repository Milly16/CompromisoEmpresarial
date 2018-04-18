<?php

namespace App\Modelo\Usuario;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Authenticatable
{
    public $timestamps = false;
    
    protected $fillable = [
        'email', 'password', 'tipo_usuario_id', 'empresa_id', 'eliminado', 'creadofecha'
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Modelo\Empresa\Empresa', 'empresa_id');
    }

    public function tipo_usuario()
    {
        return $this->belongsTo('App\Modelo\Usuario\TipoUsuario', 'tipo_usuario_id');
    }
}
