<?php

namespace App\Modelo\UnidadTrabajador;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TranTrabajador extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'dni', 'nombre', 'apellido', 'celular', 'direccion', 'nacimiento', 'brevete', 'eliminado', 'empresa_tran_id'
    ];

    public function empresatran()
    {
        return $this->belongsTo('App\Modelo\Empresa\EmpresaTran');
    }
}
