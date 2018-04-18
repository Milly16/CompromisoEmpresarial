<?php

namespace App\Modelo\Empresa;

use Illuminate\Database\Eloquent\Model;

class EmpresaGen extends Model
{
	public $timestamps = false;

    protected $fillable = [
        'id', 'ruc', 'encargnombre', 'encargapellido', 'encargtelefono'
    ];

    public function empresa()
    {
        return $this->belongsTo('App\Modelo\Empresa\Empresa','id');
    }

    public function requerimientos()
    {
        return $this->hasMany('App\Modelo\Requerimiento\GenRequerimiento');
    }
}
