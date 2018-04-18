<?php

namespace App\Modelo\Empresa;

use Illuminate\Database\Eloquent\Model;

class EmpresaTran extends Model
{
	public $timestamps = false;

    protected $fillable = [
        'id', 'archivo'
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Modelo\Empresa\Empresa','id');
    }


    public function tranunidades()
    {
        return $this->hasMany('App\Modelo\UnidadTrabajador\TranUnidad');
    }

    public function trantrabajadores()
    {
        return $this->hasMany('App\Modelo\UnidadTrabajador\TranTrabajador');
    }

    public function postulaciones()
    {
        return $this->hasMany('App\Modelo\PostulacionSeleccion\Postulacion');
    }
}
