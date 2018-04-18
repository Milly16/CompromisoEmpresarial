<?php

namespace App\Modelo\PostulacionSeleccion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seleccion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'publicacion_id', 'postulacion_id', 'visto', 'eliminado'
    ];

    public function postulaciondetalles()
    {
        return $this->hasOne('App\Modelo\PostulacionSeleccion\PostulacionDetalle',  'id' , 'postulacion_id');
    }

}
