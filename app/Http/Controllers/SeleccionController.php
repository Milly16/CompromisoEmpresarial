<?php

namespace App\Http\Controllers;

use App\Modelo\PostulacionSeleccion\Seleccion;
use App\Modelo\Publicacion\Publicacion;

use App\Modelo\PostulacionSeleccion\Postulacion;
use App\Modelo\PostulacionSeleccion\PostulacionDetalle;

use App\Modelo\Requerimiento\GenRequerimiento;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SeleccionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $rules = [];

        $messages = array();

        $validator = Validator::make($request->all(), $rules,$messages);

        $seleccion = $request->get('seleccion');

        $publicacion = Publicacion::find($id);
        $cant_post = $publicacion->requerimiento->unidadcantidad;


        $validator->after(function ($validator) use($seleccion, $cant_post)  {

            if (count($seleccion)<=0) {
                $validator->errors()->add('seleccion', 'Seleccione las postulaciones');
            }

            if (count($seleccion) != $cant_post) {
                $validator->errors()->add('idUnit', 'Necesita ingresar '.$cant_post.' postulaciones');
            }
            
        });


        if (!$validator->fails()) {

            for ($i=0; $i < count($seleccion); $i++) { 
                $selecion = Seleccion::create([
                        'publicacion_id' => $id,
                        'postulacion_id' => $seleccion[$i],
                        'visto' => 0,
                        'eliminado' => 0
                ]);
                $selecion->save();
            }

            $publicacion = Publicacion::find($id);
            $publicacion->estado = 'Cerrado';
            $publicacion->save();


            $requerimiento = GenRequerimiento::find($publicacion->gen_requerimiento_id);
            $requerimiento->estado = 'Cerrado';
            $requerimiento->save();
        }

       return response()->json($validator->messages(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function show(Selection $selection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function edit(Selection $selection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Selection $selection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Selection  $selection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Selection $selection)
    {
        //
    }

    public function listadoPb()
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $publicaciones = Publicacion::with('requerimiento')
                        -> where('estado', 'postulando')
                        ->orderBy('fechaExpiracion', 'asc')
                        ->paginate(3);

        return view('Postulacion-Seleccion.publicaciones')->with(compact('publicaciones'));
    }

    public function listadoPo($id)
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $postulaciones = Postulacion::where('publicacion_id', $id)->get();

        foreach($postulaciones as $postulacion)
        {
            $postulacion->visto = 1;
            $postulacion->save();
        }

        return view('Postulacion-Seleccion.postulaciones')->with(compact('postulaciones','id'));
    }

    public function detailsPo($id)
    {
       
        $detallesPostulacion = PostulacionDetalle::where('postulacion_id', $id)->with('unidad')->with('trabajador')->get();
        return $detallesPostulacion;
    }

    public function detailsSe($id)
    {
       $seleccion = Seleccion::where('publicacion_id', $id)
                            ->with(array('postulaciondetalles' => function($query) {
                                $query->with('unidad')
                                    ->with('trabajador')
                                    ->with(array('postulacion' => function($query) {
                                        $query->with(array('empresatran' => function($query) {
                                            $query->with('empresa');
                                        }));
                                    }));
                            }))
                            ->get();
       return $seleccion;
    }



}
