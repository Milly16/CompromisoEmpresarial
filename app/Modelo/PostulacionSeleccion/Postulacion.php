<?php

namespace App\Modelo\PostulacionSeleccion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Postulacion extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'publicacion_id', 'empresa_tran_id', 'visto', 'eliminado', 'creadofecha'
    ];

    public function empresatran()
    {
        return $this->belongsTo('App\Modelo\Empresa\EmpresaTran', 'empresa_tran_id');
    }

    public function publicacion()
    {
        return $this->belongsTo('App\Modelo\Publicacion\Publicacion', 'publicacion_id');
    }
    
    public function postulaciondetalle()
    {
        return $this->hasMany('App\Modelo\PostulacionSeleccion\PostulacionDetalle');
    }
}
