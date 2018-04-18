<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Modelo\Requerimiento\GenRequerimiento;
use App\Modelo\Publicacion\Publicacion;
use App\Modelo\PostulacionSeleccion\Postulacion;
use App\Modelo\PostulacionSeleccion\PostulacionDetalle;

use Carbon\Carbon;
use DB;

class NotificacionController extends Controller
{

    public function nrequerimiento()
    {
        $now = Carbon::now();
        $nrequerimientos = GenRequerimiento::with('empresagen')
                        ->where('maximafecha','>',$now)
                        ->where('estado','nuevo')
                        ->orderBy('maximafecha', 'asc')
                        ->where('eliminado', 0)
                        ->where('visto', 0)
                        ->get();


        return $nrequerimientos;
    }

    public function npublicacion()
    {
        $now = Carbon::now();
        $publicaciones = Publicacion::with(array('requerimiento'=>function($query){
                                $query->with('iniciod')
                                    ->with('finald');
                            }))
                        ->where('eliminado', 0)
                        ->where('fechaexpiracion','>',$now)
                        ->where(function ($query) {
                            $query->where('estado','nuevo')
                                  ->orWhere('estado','postulando');
                        })
                        ->whereNotIn('id', function($query) {
                                $query->select('publicacion_id')
                                ->from('publicacion_vistos')
                                ->where('notificacion', '1')
                                ->where('empresa_tran_id', Auth::user()->empresa->id);
                        })
                        ->get();

        return $publicaciones;
    }

    public function npostulacion()
    {
        $now = Carbon::now();
        $publicaciones = DB::table('postulacions')
                        ->select(array('postulacions.id','postulacions.publicacion_id','Df.descripcion as Df','Di.descripcion as Di','empresas.razonSocial',DB::raw('COUNT(postulacion_detalles.id) as detalle')))
                        ->join('postulacion_detalles','postulacions.id','=','postulacion_detalles.postulacion_id')
                        ->join('empresas','postulacions.empresa_tran_id','=','empresas.id')
                        ->join('publicacions','postulacions.publicacion_id','=','publicacions.id')
                        ->join('gen_requerimientos','publicacions.gen_requerimiento_id','=','gen_requerimientos.id')
                        ->join('distritos as Df','gen_requerimientos.finald_id','=','Df.id')
                        ->join('distritos as Di','gen_requerimientos.iniciod_id','=','Di.id')
                        ->where('postulacions.visto', 0)
                        ->groupBy('postulacions.id')
                        ->get();


        return $publicaciones;
    }

    public function httpushR(Request $request)
    {

        $timestamp = $request->get('timestamp');

        $fecha_ac = isset($timestamp) ? $timestamp : 0 ;
        $fecha_bd = null;

        while ( $fecha_bd <= $fecha_ac) 
        {
            $query = GenRequerimiento::orderBy('creadofecha', 'desc') 
                ->where('estado','Nuevo')
                ->where('visto',0)
                ->take(1) 
                ->get(['id','creadofecha']);

            usleep(100000);
            clearstatcache();

            if (count($query) == 0) {
                $fecha_bd = strtotime(date("Y-m-d H:i:s"));
            }else{
                $fecha_bd = strtotime($query[0]->creadofecha);
            }

            
            /*die(var_dump($fecha_bd));*/
        } 
        
        $query = GenRequerimiento::orderBy('creadofecha', 'desc') 
                ->where('estado','Nuevo')
                ->where('visto',0)
                ->take(1) 
                ->get();

        if (count($query) == 0) {
            $ar["timestamp"] = strtotime(date("Y-m-d H:i:s"));
            $ar["mensaje"] = "";
        }else{
            foreach ($query as $querys) {
                $ar["timestamp"] = strtotime($query[0]->creadofecha);
                $ar["mensaje"] = $query[0]->id;
            }
        }
        echo json_encode($ar);
    }

    public function mensajeR(Request $request)
    {
        $query = GenRequerimiento::where('estado','Nuevo')
                ->where('visto',0)
                ->get();

        echo json_encode(count($query));
    }

    public function httpushPb(Request $request)
    {

        $timestamp = $request->get('timestamp');

        $fecha_ac = isset($timestamp) ? $timestamp : 0 ;
        $fecha_bd = null;

        while ( $fecha_bd <= $fecha_ac) 
        {
            $query = Publicacion::where(function ($query) {
                            $query->where('estado','nuevo')
                                  ->orWhere('estado','postulando');
                        })
                        ->where('eliminado', 0)
                        ->whereNotIn('id', function($query) {
                                $query->select('publicacion_id')
                                ->from('publicacion_vistos')
                                ->where('notificacion', '1')
                                ->where('empresa_tran_id', Auth::user()->empresa->id);
                        })
                        ->take(1) 
                        ->get(['id','fechaexpiracion']);

            usleep(100000);
            clearstatcache();

            if (count($query) == 0) {
                $fecha_bd = strtotime(date("Y-m-d H:i:s"));
            }else{
                $fecha_bd = strtotime($query[0]->fechaexpiracion);
            }

            
            /*die(var_dump($fecha_bd));*/
        } 
        
        $query = Publicacion::where(function ($query) {
                            $query->where('estado','nuevo')
                                  ->orWhere('estado','postulando');
                        })
                        ->whereNotIn('id', function($query) {
                                $query->select('publicacion_id')
                                ->from('publicacion_vistos')
                                ->where('notificacion', '1')
                                ->where('empresa_tran_id', Auth::user()->empresa->id);
                        })
                        ->take(1) 
                        ->get();

        if (count($query) == 0) {
            $ar["timestamp"] = strtotime(date("Y-m-d H:i:s"));
            $ar["mensaje"] = "";
        }else{
            foreach ($query as $querys) {
                $ar["timestamp"] = strtotime($query[0]->fechaexpiracion);
                $ar["mensaje"] = $query[0]->id;
            }
        }
        echo json_encode($ar);
    }

    public function mensajePb(Request $request)
    {
        $query = Publicacion::where(function ($query) {
                            $query->where('estado','nuevo')
                                  ->orWhere('estado','postulando');
                        })
                        ->where('eliminado', 0)
                        ->whereNotIn('id', function($query) {
                                $query->select('publicacion_id')
                                ->from('publicacion_vistos')
                                ->where('notificacion', '1')
                                ->where('empresa_tran_id', Auth::user()->empresa->id);
                        })
                        ->take(1) 
                        ->get();

        echo json_encode(count($query));
    }

    public function httpushPo(Request $request)
    {

        $timestamp = $request->get('timestamp');

        $fecha_ac = isset($timestamp) ? $timestamp : 0 ;
        $fecha_bd = null;

        while ( $fecha_bd <= $fecha_ac) 
        {
            $query = Postulacion::where('visto',0)
                ->take(1) 
                ->get();

            usleep(100000);
            clearstatcache();

            $fecha_bd = strtotime(date("Y-m-d H:i:s"));
            /*die(var_dump($fecha_bd));*/
        } 
        
        $query = Postulacion::where('visto',0)
                ->take(1) 
                ->get();

        $ar["timestamp"] = strtotime(date("Y-m-d H:i:s"));
        $ar["mensaje"] = "";
        echo json_encode($ar);
    }

    public function mensajePo(Request $request)
    {
        $query = Postulacion::where('visto',0)
                ->get();

        echo json_encode(count($query));
    }
}
