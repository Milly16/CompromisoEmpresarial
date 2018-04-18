<?php

namespace App\Modelo\Requerimiento;

use Illuminate\Database\Eloquent\Model;

class GenRequerimiento extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'producto', 'pesoneto', 'pesounidad', 'iniciod_id', 'iniciodireccion', 'iniciofecha', 'finald_id', 'finaldireccion', 'finalfecha', 'maximafecha', 'unidadcantidad', 'unidadrequisito', 'unidadtipo', 'pagometodo', 'pagomoneda', 'pagomonto', 'cantdias', 'igv', 'seguro', 'porTn', 'estado', 'empresa_gen_id', 'creadofecha'
    ];

    public function empresagen()
    {
        return $this->belongsTo('App\Modelo\Empresa\EmpresaGen','empresa_gen_id','id');
    }

    public function empresa()
    {
        return $this->belongsTo('App\Modelo\Empresa\Empresa','empresa_gen_id','id');
    }

   
    public function iniciod()
	{
	    return $this->belongsTo('App\Modelo\Ubigeo\Distrito', 'iniciod_id');
	}

	public function finald()
	{
	    return $this->belongsTo('App\Modelo\Ubigeo\Distrito', 'finald_id');
	}

}
