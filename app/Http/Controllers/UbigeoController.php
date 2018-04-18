<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modelo\Ubigeo\Provincia;
use App\Modelo\Ubigeo\Distrito;

class UbigeoController extends Controller
{
    public function getProvincia($id)
    {
        return Provincia::where('departamento_id',$id)->get();
    }

    public function getDistrito($id)
    {
        return Distrito::where('provincia_id',$id)->get();
    }
}
