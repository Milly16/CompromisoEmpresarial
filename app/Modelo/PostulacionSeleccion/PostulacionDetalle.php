<?php

namespace App\Modelo\PostulacionSeleccion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostulacionDetalle extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'postulacion_id', 'trans_unidad_id', 'trans_trabajador_id'
    ];


    public function postulacion()
    {
        return $this->belongsTo('App\Modelo\PostulacionSeleccion\Postulacion', 'postulacion_id');
    }

    public function unidad()
    {
        return $this->belongsTo('App\Modelo\UnidadTrabajador\TranUnidad', 'trans_unidad_id');
    }

    public function trabajador()
    {
        return $this->belongsTo('App\Modelo\UnidadTrabajador\TranTrabajador', 'trans_trabajador_id');
    }

    public function seleccion()
    {
        return $this->belongsTo('App\Modelo\PostulacionSeleccion\Seleccion');
    }

}
