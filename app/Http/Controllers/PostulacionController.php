<?php

namespace App\Http\Controllers;

use App\Modelo\PostulacionSeleccion\Postulacion;
use App\Modelo\PostulacionSeleccion\PostulacionDetalle;
use App\Modelo\Publicacion\Publicacion;
use App\Modelo\Publicacion\PublicacionVisto;
use App\Modelo\UnidadTrabajador\TranTrabajador;
use App\Modelo\UnidadTrabajador\TranUnidad;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostulacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postulaciones = Postulacion::where('empresa_tran_id', Auth::user()->empresa->id )
                    ->get();

        return view('Postulacion-Seleccion.listado')->with(compact('postulaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $publicacion = Publicacion::find($id);
        if (! $publicacion) 
            return redirect('/home');

        $npublicacion_notificacion = PublicacionVisto::where('publicacion_id',$id)
                                                    ->where('empresa_tran_id', Auth::user()->empresa->id)
                                                    ->first();
        $npublicacion_notificacion->notificacion = 1;
        $npublicacion_notificacion->save();

        $unidades = TranUnidad::with('empresatran')
                        ->where('empresa_tran_id', Auth::user()->empresa->id)
                        ->orderBy('id', 'desc')
                        ->paginate(3);

        $trabajadores = TranTrabajador::with('empresatran')
                        ->where('empresa_tran_id', Auth::user()->empresa->id)
                        ->orderBy('id', 'desc')
                        ->get();
        
        return view('Postulacion-Seleccion.nuevo')->with(compact('publicacion','unidades','trabajadores'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $rules = [];

        $messages = array();     

        $validator = Validator::make($request->all(), $rules,$messages);

        $unidades = $request->get('idUnit');
        $trabajadores = $request->get('idWorked');

        $publicacion = Publicacion::find($id);
        $cant_unid = $publicacion->requerimiento->unidadcantidad;


        $validator->after(function ($validator) use($unidades, $trabajadores, $cant_unid)  {

            if (count($unidades)<=0) {
                $validator->errors()->add('idUnit', 'Seleccione sus unidades');
            }

            if (count($unidades) != $cant_unid) {
                $validator->errors()->add('idUnit', 'Necesita ingresar '.$cant_unid.' unidades');
            }

            for ($i=0; $i < count($trabajadores); $i++) { 
                if ($trabajadores[$i] == '0') {
                   $validator->errors()->add('idWorked', 'Seleccione su trabajador');
                }
            }

            for ($i=0; $i < count($unidades); $i++) { 
                $unit = TranUnidad::find($unidades[$i]);  
                if ($unit == NULL) {
                    $validator->errors()->add('idUnit', 'No existe dicha unidad');
                }
            }

            for ($i=0; $i < count($trabajadores); $i++) { 
                $worker = TranTrabajador::find($trabajadores[$i]);  
                if ($worker == NULL) {
                    $validator->errors()->add('idWorked', 'No existe dicho trabajador');
                }
            }

            if (count($trabajadores)>0) {
               if (count($trabajadores) != count(array_unique($trabajadores))) {
                    $validator->errors()->add('idWorked', 'Hay trabajadores iguales');
                }
            }
            
            if (count($unidades)>0) {
                if (count($unidades) != count(array_unique($unidades))) {
                    $validator->errors()->add('idWorked', 'Hay dos trabajadores unidades');
                }
            }
            
        });


        if (!$validator->fails()) {

            $postulacion = Postulacion::create([
                        'publicacion_id' => $id,
                        'empresa_tran_id' => Auth::user()->empresa->id,
                        'visto' => 0,
                        'eliminado' => 0,
                        'creadofecha' => Carbon::now()->toDateTimeString()
                ]);
                $postulacion->save();



            for ($i=0; $i < count($unidades); $i++) { 
                $detalle = PostulacionDetalle::create([
                        'postulacion_id' => $postulacion->id,
                        'trans_unidad_id' => $unidades[$i],
                        'trans_trabajador_id' => $trabajadores[$i],
                ]);
                $detalle->save();
            }

            $publicacion = Publicacion::find($id);
            $publicacion->estado = 'Postulando';
            $publicacion->save();

            $publicacionvisto_id = PublicacionVisto::where('publicacion_id', $id) 
                        ->where('empresa_tran_id',Auth::user()->empresa->id)
                        ->first();

            $publicacionvisto = PublicacionVisto::find($publicacionvisto_id->id);
            $publicacionvisto->visto = 1;
            $publicacionvisto->save();
        
        }

       return response()->json($validator->messages(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Postulation  $postulation
     * @return \Illuminate\Http\Response
     */
    public function show(Postulation $postulation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Postulation  $postulation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $postulacion = Postulacion::find($id);
        $detallesPostulacion = PostulacionDetalle::where('postulacion_id', $id)->get();

        $unidades = TranUnidad::with('empresatran')
                        ->where('empresa_tran_id', Auth::user()->empresa->id)
                        ->orderBy('id', 'desc')
                        ->whereNotIn('id', function($query) {
                                $query->select('trans_unidad_id')
                                ->from('postulacion_detalles');
                        })
                        ->paginate(3);

        $trabajadores = TranTrabajador::with('empresatran')
                        ->where('empresa_tran_id', Auth::user()->empresa->id)
                        ->orderBy('id', 'desc')
                        ->get();

        return view('Postulacion-Seleccion.editar')->with(compact('postulacion', 'detallesPostulacion', 'unidades', 'trabajadores'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Postulation  $postulation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    { 
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $rules = [];

        $messages = array();     

        $validator = Validator::make($request->all(), $rules,$messages);

        $unidades = $request->get('idUnit');
        $trabajadores = $request->get('idWorked');

        $postulacion = Postulacion::find($id);
        $publicacion = Publicacion::find($postulacion->publicacion->id);
        $cant_unid = $publicacion->requerimiento->unidadcantidad;


        $validator->after(function ($validator) use($unidades, $trabajadores, $cant_unid)  {

            if (count($unidades)<=0) {
                $validator->errors()->add('idUnit', 'Seleccione sus unidades');
            }

            if (count($unidades) != $cant_unid) {
                $validator->errors()->add('idUnit', 'Necesita ingresar '.$cant_unid.' unidades');
            }

            for ($i=0; $i < count($trabajadores); $i++) { 
                if ($trabajadores[$i] == '0') {
                   $validator->errors()->add('idWorked', 'Seleccione su trabajador');
                }
            }

            for ($i=0; $i < count($unidades); $i++) { 
                $unit = TranUnidad::find($unidades[$i]);  
                if ($unit == NULL) {
                    $validator->errors()->add('idUnit', 'No existe dicha unidad');
                }
            }

            for ($i=0; $i < count($trabajadores); $i++) { 
                $worker = TranTrabajador::find($trabajadores[$i]);  
                if ($worker == NULL) {
                    $validator->errors()->add('idWorked', 'No existe dicho trabajador');
                }
            }

            if (count($trabajadores)>0) {
               if (count($trabajadores) != count(array_unique($trabajadores))) {
                    $validator->errors()->add('idWorked', 'Hay trabajadores iguales');
                }
            }
            
            if (count($unidades)>0) {
                if (count($unidades) != count(array_unique($unidades))) {
                    $validator->errors()->add('idWorked', 'Hay dos trabajadores unidades');
                }
            }
            
        });


        if (!$validator->fails()) {

            PostulacionDetalle::where('postulacion_id', $id)->delete();


            for ($i=0; $i < count($unidades); $i++) { 
                $detalle = PostulacionDetalle::create([
                        'postulacion_id' => $id,
                        'trans_unidad_id' => $unidades[$i],
                        'trans_trabajador_id' => $trabajadores[$i],
                ]);
                $detalle->save();
            }
        
        }

       return response()->json($validator->messages(), 200);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Postulation  $postulation
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $id = $request->get('id');
        $postulacion = Postulacion::find($id);

        $npublicacion_notificacion = PublicacionVisto::where('publicacion_id',$postulacion->publicacion->id)
                                                    ->where('empresa_tran_id', Auth::user()->empresa->id)
                                                    ->first();
        $npublicacion_notificacion->visto = 0;
        $npublicacion_notificacion->save();

        $postulaciondetalle = PostulacionDetalle::where('postulacion_id', $id);
        
        $postulaciondetalle->delete();
        $postulacion->delete();


    }

    public function details($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $postulacion = Postulacion::find($id);
        $detallesPostulacion = PostulacionDetalle::where('postulacion_id', $id)->get();
        if (!$postulacion) 
            return redirect('/postulacion/listado');


        return view('Postulacion-Seleccion.detalle')->with(compact('postulacion', 'detallesPostulacion'));

    }
}
