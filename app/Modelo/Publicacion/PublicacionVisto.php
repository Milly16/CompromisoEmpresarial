<?php

namespace App\Modelo\Publicacion;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PublicacionVisto extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'publicacion_id', 'empresa_tran_id', 'visto'
    ];

    public function publicacion()
	{
	    return $this->belongsTo('App\Modelo\Publicacion\Publicacion');
	}

	public function empresatrans()
    {
        return $this->hasMany('App\CompanyTrans');
    }
}
