<?php

namespace App\Modelo\Publicacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'pagomonto', 'fechaexpiracion', 'estado', 'gen_requerimiento_id'
    ];

    public function requerimiento()
    {
        return $this->belongsTo('App\Modelo\Requerimiento\GenRequerimiento', 'gen_requerimiento_id');
    }

    public function publicacionvistos()
    {
        return $this->hasMany('App\Modelo\Publicacion\PublicacionVisto');
    }

    public function postulaciones()
    {
        return $this->hasMany('App\Modelo\PostulacionSeleccion\Postulacion');
    }
}
