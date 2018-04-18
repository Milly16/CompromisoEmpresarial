<?php

namespace App\Modelo\Empresa;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'ruc', 'razonsocial', 'contnombre', 'contapellido', 'conttelefono', 'direccion', 'distrito_id'
    ];
	
	public function distrito()
    {
        return $this->belongsTo('App\Modelo\Ubigeo\Distrito', 'distrito_id');
    }

    public function usuario()
    {
        return $this->hasOne('App\Modelo\Usuario\Usuario');
    }

    public function empresa_gen()
    {
        return $this->hasOne('App\Modelo\Empresa\EmpresaGen', 'id');
    }

    public function empresa_tran()
    {
        return $this->hasOne('App\Modelo\Empresa\EmpresaTran', 'id');
    }

    public function requerimientos()
    {
        return $this->hasMany('App\Modelo\Requerimiento\GenRequerimiento');
    }
}
