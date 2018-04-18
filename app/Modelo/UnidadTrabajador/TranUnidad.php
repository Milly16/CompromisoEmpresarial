<?php

namespace App\Modelo\UnidadTrabajador;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TranUnidad extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'tipo', 'marca', 'modelo', 'color', 'anio', 'pesobruto', 'placatracto', 'mtctracto', 'placacarreta', 'mtccarreta', 'fechasoat', 'nsoat', 'largo', 'ancho', 'alto', 'eliminado', 'empresa_tran_id'
    ];


    public function empresatran()
    {
        return $this->belongsTo('App\Modelo\Empresa\EmpresaTran');
    }

    public function postulaciondetalle()
    {
        return $this->hasMany('App\Modelo\Publicacion\PostulacionDetalle');
    }
}
