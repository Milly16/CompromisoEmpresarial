<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Modelo\Requerimiento\GenRequerimiento;
use App\Modelo\Publicacion\Publicacion;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        $requerimientos = GenRequerimiento::with('iniciod')
                        ->with('finald')
                        ->where('empresa_gen_id', Auth::user()->empresa->id)
                        ->where('eliminado', 0)
                        ->orderBy('id', 'desc')
                        ->paginate(4);

        $now = Carbon::now();

        $nrequerimientos = GenRequerimiento::with('empresagen')
                        ->where('maximafecha','>',$now)
                        ->where('estado','nuevo')
                        ->orderBy('maximafecha', 'asc')
                        ->where('eliminado', 0)
                        ->paginate(3);

        $publicaciones = Publicacion::with('requerimiento')
                        ->where('eliminado', 0)
                        ->where('fechaexpiracion','>',$now)
                        ->where(function ($query) {
                            $query->where('estado','nuevo')
                                  ->orWhere('estado','postulando');
                        })
                        ->whereNotIn('id', function($query) {
                                $query->select('publicacion_id')
                                ->from('publicacion_vistos')
                                ->where('visto', '1')
                                ->where('empresa_tran_id', Auth::user()->empresa->id);
                        })
                        ->paginate(3);
       


        if (Auth::check()) {
            switch (Auth::user()->tipo_usuario_id) {
                case 1: return view('Publicacion.nrequerimientos')->with(compact('nrequerimientos'));
                case 2: return view('Requerimiento.listado')->with(compact('requerimientos'));
                case 3: return view('Postulacion-Seleccion.npublicacion')->with(compact('publicaciones'));
            }
        }
        return view('welcome');
    }


}
