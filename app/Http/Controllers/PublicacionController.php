<?php

namespace App\Http\Controllers;


use App\Modelo\Requerimiento\GenRequerimiento;
use App\Modelo\Usuario\Usuario;
use App\Modelo\Publicacion\Publicacion;
use App\Modelo\Publicacion\PublicacionVisto;
use App\Modelo\Ubigeo\Departamento;
use App\Modelo\Ubigeo\Provincia;
use App\Modelo\Ubigeo\Distrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;


class PublicacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $publicaciones = Publicacion::with('requerimiento')
                        ->where('eliminado', 0)
                        ->orderBy('id', 'desc')
                        ->paginate(3);

        /*dd($publicaciones->requerimiento->producto);;*/

        return view('Publicacion.listado')->with(compact('publicaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createP($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $requerimiento = GenRequerimiento::find($id);

        $requerimiento->visto = 1;
        $requerimiento->save();
        
        if (! $requerimiento) 
            return redirect('/home');

        /*$areas = User::where('type_id', 3)->get(['id']);
        $array2 = $areas->toArray();

        foreach ($array2 as $front){
            $ids = $front['id'];

        }

        dd(array_values($ids));*/

        return view('Publicacion.nuevo')->with(compact('requerimiento'));
    }

    public function createR()
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $departamentos = Departamento::all();
        return view('Publicacion.nrequerimientonuevo')->with(compact('departamentos'));
    }

    public function detailsA($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $publicacion = Publicacion::find($id);
        if (! $publicacion) 
            return redirect('/Publicacion/listado');

        $texto=$publicacion->requerimiento->unidadrequisito; 
        $texto=preg_replace("/\n+/","\n",$texto); 
        $lineas=explode("\n",$texto); 

        $inicio= $publicacion->requerimiento->iniciodireccion.','.$publicacion->requerimiento->iniciod->descripcion;
        $final= $publicacion->requerimiento->finaldireccion.','.$publicacion->requerimiento->finald->descripcion;

        $origen =  $inicio;
        $destino = $final;
        $url = 'http://maps.googleapis.com/maps/api/directions/json?origin='.urlencode($origen).'&destination='.urlencode($destino).'&region=es&sensor=false&mode=driving';
        $datos = @file_get_contents($url);
        $jsondata = json_decode($datos, true);
        $salida = array();

        if(isset($jsondata) and is_array($jsondata)){
            $salida['distancia_metros'] = $jsondata['routes'][0]['legs'][0]['distance']['value'];
            $salida['duracion_segundos'] = $jsondata['routes'][0]['legs'][0]['duration']['value'];
            $salida['distancia'] = $jsondata['routes'][0]['legs'][0]['distance']['text'];
            $salida['duration'] = $jsondata['routes'][0]['legs'][0]['duration']['text'];
        }

        $distancia = $salida['distancia'];
        $tiempo = $salida['duration'];

        $galon = round(0.120805016 * $distancia,2);

        return view('Publicacion.detalle')->with(compact('publicacion','lineas', 'distancia', 'tiempo', 'galon'));
    }

    public function detailsT($id)
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $npublicacion = Publicacion::find($id);
        if (! $npublicacion) 
            return redirect('/Publicacion/listado');

        $npublicacion_notificacion = PublicacionVisto::where('publicacion_id',$id)
                                                    ->where('empresa_tran_id', Auth::user()->empresa->id)
                                                    ->first();
        $npublicacion_notificacion->notificacion = 1;
        $npublicacion_notificacion->save();
       

        $texto=$npublicacion->requerimiento->unidadrequisito; 
        $texto=preg_replace("/\n+/","\n",$texto); 
        $lineas=explode("\n",$texto); 

        return view('Postulacion-Seleccion.npublicaciondetalle')->with(compact('npublicacion','lineas'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeP(Request $request, $id)
    {
        $rules = [
            'pagoMonto' => 'required|numeric|min:1',
            'expiracionFecha' => 'required|date_format:"Y-m-d',
            'expiracionHora' => 'required|date_format:"H:i',
        ];

        $messages = array(
            'expiracionFecha.required' => 'Es necesario ingresar la fecha de expiracion',
            'expiracionHora.required' => 'Es necesario ingresar la hora de expiracion',
            'pagoMonto.required' => 'Es necesario ingresar el monto de pago',

            'pagoMonto.numeric' => 'El monto de pago debe ser numerico',
            'pagoMonto.min' => 'El monto de pago debe ser mayor a 1.00',
            
            'expiracionFecha.date_format' => 'El formato de la fecha de expiracion no es valido',
            'expiracionHora.date_format' => 'El formato de la hora de expiracion no es valido'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        $now = Carbon::now()->toDateTimeString();
        $requerimiento = GenRequerimiento::find($id);
        $maximaFecha = $requerimiento->maximafecha;

        $fechaExpiracion = $request->get('expiracionFecha').' '.$request->get('expiracionHora');

        $pagoRequerimiento = $requerimiento->pagomonto;
        $pagoPublicacion = $request->get('pagoMonto');

        // die(var_dump($fechaExpiracion));

        $validator->after(function ($validator) use($maximaFecha, $fechaExpiracion, $now, $pagoRequerimiento, $pagoPublicacion)  {

            if ($maximaFecha < $fechaExpiracion) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser menor a la fecha maxima');
            }

            if ($fechaExpiracion < $now) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser mayor a la fecha actual');
            }

            if ($pagoRequerimiento <= $pagoPublicacion ) {
                $validator->errors()->add('pagoMonto', 'El pago de la publicacion debe ser menor al del requerimiento');
            }
        });

        if (!$validator->fails()) {

            $publicacion = Publicacion::create([
                    'pagomonto' => $pagoPublicacion,
                    'fechaexpiracion' => $fechaExpiracion,
                    'estado' => 'Nuevo',
                    'gen_requerimiento_id' => $id
            ]);
            $publicacion->save();

            $genrequest = GenRequerimiento::find($id);
            $genrequest->estado = 'Aceptado';
            $genrequest->save();

            $transportistas = Usuario::where('tipo_usuario_id',3)->get();
            foreach($transportistas as $transportista)
            {
                $public_view = PublicacionVisto::create([
                    'publicacion_id' => $publicacion->id,
                    'empresa_tran_id' => $transportista->empresa_id,
                    'visto' => 0,
                ]);
                $publicacion->save();
            }
        }

        return response()->json($validator->messages(), 200);

    }

    public function storeR(Request $request)
    {

        $rules = [
            'producto' => 'required',
            'pesoNeto' => 'required',
            'pesoUnidad' => 'required|in:Kg,Tn,Lb,Lt,M3',
            'iniciodistrito' => 'required|exists:distritos,id',
            'inicioDireccion' => 'required',
            'inicioFecha' => 'required|date_format:"Y-m-d',
            'inicioHora' => 'required|date_format:"H:i',
            'finaldistrito' => 'required|exists:distritos,id',
            'finalDireccion' => 'required',
            'finalFecha' => 'required|date_format:"Y-m-d',
            'maximaFecha' => 'required|date_format:"Y-m-d',
            'maximaHora' => 'required|date_format:"H:i',
            'unidadCantidad' => 'required|integer',
            'unidadTipo' => 'required',
            'unidadRequisito' => 'required',
            'pagoMetodo' => 'required|in:contado,credito',
            'pagoMoneda' => 'required|in:sol,dol',
            'pagoMonto' => 'required|numeric|min:1',
            'pagoPublicacion' => 'required|numeric|min:1',
            'expiracionFecha' => 'required|date_format:"Y-m-d',
            'expiracionHora' => 'required|date_format:"H:i',
        ];

        $messages = array(
            'producto.required' => 'Es necesario ingresar el producto',
            'pesoNeto.required' => 'Es necesario ingresar el peso neto de la carga',
            'pesoUnidad.required' => 'Es necesario seleccionar la unidad del peso', 
            'iniciodistrito.required' => 'Es necesario ingresar el distrito de recojo', 
            'inicioDireccion.required' => 'Es necesario ingresar la direccion de recojo',
            'inicioFecha.required' => 'Es necesario ingresar la fecha de recojo',
            'inicioHora.required' => 'Es necesario ingresar la hora de recojo',
            'finaldistrito.required' => 'Es necesario ingresar el distrito de entrega',
            'finalDireccion.required' => 'Es necesario ingresar la direccion de entrega',
            'finalFecha.required' => 'Es necesario ingresar la fecha de entrega',
            'maximaFecha.required' => 'Es necesario ingresar la maxima fecha de busqueda',
            'maximaHora.required' => 'Es necesario ingresar la maxima hora de busqueda',
            'unidadCantidad.required' => 'Es necesario ingresar la cantidad de unidades',
            'unidadTipo.required' => 'Es necesario ingresar el tipo de unidades',
            'unidadRequisito.required' => 'Es necesario ingresar los aspectos de las unidades',
            'pagoMetodo.required' => 'Es necesario seleccionar el metodo de pago',
            'pagoMoneda.required' => 'Es necesario seleccionar  el tipo de moneda',
            'pagoMonto.required' => 'Es necesario ingresar el monto de pago',

            'pesoUnidad.in' => 'El peso de la carga no es valida',
            'pagoMetodo.in' => 'El metodo de pago no es valida',
            'pagoMoneda.in' => 'La moneda de pago no es valida',
            'iniciodistrito.exists' => 'El distrito de recojo no es valido',
            'finaldistrito.exists' => 'El distrito de entrega no es valido',

            'inicioFecha.date_format' => 'El formato de la fecha de recojo no es valido',
            'inicioHora.date_format' => 'El formato de la hora de recojo no es valido',
            'finalFecha.date_format' => 'El formato de la fecha de entrega no es valido',
            'maximaFecha.date_format' => 'El formato de la fecha maxima no es valido',
            'maximaHora.date_format' => 'El formato de la hora maxima no es valido',

            'expiracionFecha.required' => 'Es necesario ingresar la fecha de expiracion',
            'expiracionHora.required' => 'Es necesario ingresar la hora de expiracion',
            'pagoPublicacion.required' => 'Es necesario ingresar el monto de pago',

            'pagoPublicacion.numeric' => 'El monto de pago debe ser numerico',
            'pagoPublicacion.min' => 'El monto de pago debe ser mayor a 1.00',
            
            'expiracionFecha.date_format' => 'El formato de la fecha de expiracion no es valido',
            'expiracionHora.date_format' => 'El formato de la hora de expiracion no es valido'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        $now = Carbon::now()->toDateTimeString();
        $iniciofecha = $request->get('inicioFecha').' '.$request->get('inicioHora');
        $finalfecha = $request->get('finalFecha').' 00:00';
        $fechamaxima = $request->get('maximaFecha').' '.$request->get('maximaHora');

        $fechaExpiracion = $request->get('expiracionFecha').' '.$request->get('expiracionHora');

        $pagoRequerimiento = $request->get('pagoMonto');
        $pagoPublicacion = $request->get('pagoPublicacion');

        // die(var_dump($fechaExpiracion));

        $validator->after(function ($validator) use($iniciofecha, $finalfecha, $fechamaxima, $fechaExpiracion, $now, $pagoRequerimiento, $pagoPublicacion)  {

            if ($iniciofecha < $now) {
                $validator->errors()->add('inicioFecha', 'La fecha de recojo debe ser mayor a la fecha actual');
            }

            if ($finalfecha < $now) {
                $validator->errors()->add('finalFecha', 'La fecha de entrega debe ser mayor a la fecha actual');
            }

            if ($iniciofecha > $finalfecha) {
                $validator->errors()->add('finalFecha', 'La fecha de entrega debe ser mayor a la fecha de recojo ');
            }

            if ($fechamaxima > $iniciofecha) {
                $validator->errors()->add('maximaFecha', 'La fecha maxima debe ser menor a la fecha de recojo ');
            }

             if ($fechamaxima > $finalfecha) {
                $validator->errors()->add('maximaFecha', 'La fecha maxima debe ser menor a la fecha de entrega ');
            }

            if ($fechamaxima < $fechaExpiracion) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser menor a la fecha maxima');
            }

            if ($fechaExpiracion < $now) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser mayor a la fecha actual');
            }

            if ($pagoRequerimiento <= $pagoPublicacion ) {
                $validator->errors()->add('pagoMonto', 'El pago de la publicacion debe ser menor al del requerimiento');
            }
        });

        if ($request->get('cantDias') == "") {
            $cantDias = "0";
        } else {
            $cantDias = $request->get('cantDias');
        }

        if (!$validator->fails()) {

            $requerimiento = GenRequerimiento::create([
                    'producto' => $request->get('producto'),
                    'pesoneto' => $request->get('pesoNeto'),
                    'pesounidad' => $request->get('pesoUnidad'),
                    'iniciod_id' => $request->get('iniciodistrito'),
                    'iniciodireccion' => $request->get('inicioDireccion'),
                    'iniciofecha' => $iniciofecha,
                    'finald_id' => $request->get('finaldistrito'),
                    'finaldireccion' => $request->get('finalDireccion'),
                    'finalfecha' => $request->get('finalFecha'),
                    'maximafecha' => $fechamaxima,
                    'unidadcantidad' => $request->get('unidadCantidad'),
                    'unidadrequisito' => $request->get('unidadRequisito'),
                    'unidadtipo' => $request->get('unidadTipo'),
                    'pagometodo' => $request->get('pagoMetodo'),
                    'pagomoneda' => $request->get('pagoMoneda'),
                    'pagomonto' => $request->get('pagoMonto'),
                    'cantdias' => $cantDias,
                    'igv' => $request->get('igv') ? 1 : 0,
                    'seguro' => $request->get('seguro') ? 1 : 0,
                    'portn' => $request->get('porTn') ? 1 : 0,
                    'estado' => 'Aceptado',
                    'empresa_gen_id' => Auth::user()->empresa->id,
                    'creadofecha' => Carbon::now()->toDateTimeString()
            ]);
            $requerimiento->save();


            $publicacion = Publicacion::create([
                    'pagomonto' => $pagoPublicacion,
                    'fechaexpiracion' => $fechaExpiracion,
                    'estado' => 'Nuevo',
                    'gen_requerimiento_id' => $requerimiento->id
            ]);
            $publicacion->save();

            $transportistas = Usuario::where('tipo_usuario_id',3)->get();
            foreach($transportistas as $transportista)
            {
                $public_view = PublicacionVisto::create([
                    'publicacion_id' => $publicacion->id,
                    'empresa_tran_id' => $transportista->empresa_id,
                    'visto' => 0,
                ]);
                $publicacion->save();
            }
        }

        return response()->json($validator->messages(), 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function show(Publication $publication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $publicacion = Publicacion::find($id);        
        if (!$publicacion) 
            return redirect('/home');
        
        $departamentos = Departamento::all();

        $i_departamento = $publicacion->requerimiento->iniciod->provincia->departamento_id;
        $i_provincias = Provincia::all()
                        ->where('departamento_id', $i_departamento); 

        $i_provincia = $publicacion->requerimiento->iniciod->provincia_id;
        $i_distritos = Distrito::all()
                        ->where('provincia_id', $i_provincia); 

        $f_departamento = $publicacion->requerimiento->finald->provincia->departamento_id;
        $f_provincias = Provincia::all()
                        ->where('departamento_id', $f_departamento);  

        $f_provincia = $publicacion->requerimiento->finald->provincia_id;
        $f_distritos = Distrito::all()
                        ->where('provincia_id', $f_provincia); 

        /*dd($i_distritos);*/

        return view('Publicacion.editar')->with(compact('publicacion', 'departamentos', 'i_provincias', 'i_distritos', 'f_provincias', 'f_distritos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function updateN(Request $request, $id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $rules = [
            'producto' => 'required',
            'pesoNeto' => 'required',
            'pesoUnidad' => 'required|in:Kg,Tn,Lb,Lt,M3',
            'iniciodistrito' => 'required|exists:distritos,id',
            'inicioDireccion' => 'required',
            'inicioFecha' => 'required|date_format:"Y-m-d',
            'inicioHora' => 'required|date_format:"H:i',
            'finaldistrito' => 'required|exists:distritos,id',
            'finalDireccion' => 'required',
            'finalFecha' => 'required|date_format:"Y-m-d',
            'maximaFecha' => 'required|date_format:"Y-m-d',
            'maximaHora' => 'required|date_format:"H:i',
            'unidadCantidad' => 'required|integer',
            'unidadTipo' => 'required',
            'unidadRequisito' => 'required',
            'pagoMetodo' => 'required|in:contado,credito',
            'pagoMoneda' => 'required|in:sol,dol',
            'pagoMonto' => 'required|numeric|min:1',
            'pagoPublicacion' => 'required|numeric|min:1',
            'expiracionFecha' => 'required|date_format:"Y-m-d',
            'expiracionHora' => 'required|date_format:"H:i',
        ];

        $messages = array(
            'producto.required' => 'Es necesario ingresar el producto',
            'pesoNeto.required' => 'Es necesario ingresar el peso neto de la carga',
            'pesoUnidad.required' => 'Es necesario seleccionar la unidad del peso', 
            'iniciodistrito.required' => 'Es necesario ingresar el distrito de recojo', 
            'inicioDireccion.required' => 'Es necesario ingresar la direccion de recojo',
            'inicioFecha.required' => 'Es necesario ingresar la fecha de recojo',
            'inicioHora.required' => 'Es necesario ingresar la hora de recojo',
            'finaldistrito.required' => 'Es necesario ingresar el distrito de entrega',
            'finalDireccion.required' => 'Es necesario ingresar la direccion de entrega',
            'finalFecha.required' => 'Es necesario ingresar la fecha de entrega',
            'maximaFecha.required' => 'Es necesario ingresar la maxima fecha de busqueda',
            'maximaHora.required' => 'Es necesario ingresar la maxima hora de busqueda',
            'unidadCantidad.required' => 'Es necesario ingresar la cantidad de unidades',
            'unidadTipo.required' => 'Es necesario ingresar el tipo de unidades',
            'unidadRequisito.required' => 'Es necesario ingresar los aspectos de las unidades',
            'pagoMetodo.required' => 'Es necesario seleccionar el metodo de pago',
            'pagoMoneda.required' => 'Es necesario seleccionar  el tipo de moneda',
            'pagoMonto.required' => 'Es necesario ingresar el monto de pago',

            'pesoUnidad.in' => 'El peso de la carga no es valida',
            'pagoMetodo.in' => 'El metodo de pago no es valida',
            'pagoMoneda.in' => 'La moneda de pago no es valida',
            'iniciodistrito.exists' => 'El distrito de recojo no es valido',
            'finaldistrito.exists' => 'El distrito de entrega no es valido',

            'inicioFecha.date_format' => 'El formato de la fecha de recojo no es valido',
            'inicioHora.date_format' => 'El formato de la hora de recojo no es valido',
            'finalFecha.date_format' => 'El formato de la fecha de entrega no es valido',
            'maximaFecha.date_format' => 'El formato de la fecha maxima no es valido',
            'maximaHora.date_format' => 'El formato de la hora maxima no es valido',

            'expiracionFecha.required' => 'Es necesario ingresar la fecha de expiracion',
            'expiracionHora.required' => 'Es necesario ingresar la hora de expiracion',
            'pagoPublicacion.required' => 'Es necesario ingresar el monto de pago',

            'pagoPublicacion.numeric' => 'El monto de pago debe ser numerico',
            'pagoPublicacion.min' => 'El monto de pago debe ser mayor a 1.00',
            
            'expiracionFecha.date_format' => 'El formato de la fecha de expiracion no es valido',
            'expiracionHora.date_format' => 'El formato de la hora de expiracion no es valido'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        $now = Carbon::now()->toDateTimeString();
        $iniciofecha = $request->get('inicioFecha').' '.$request->get('inicioHora');
        $finalfecha = $request->get('finalFecha').' 00:00';
        $fechamaxima = $request->get('maximaFecha').' '.$request->get('maximaHora');

        $fechaExpiracion = $request->get('expiracionFecha').' '.$request->get('expiracionHora');

        $pagoRequerimiento = $request->get('pagoMonto');
        $pagoPublicacion = $request->get('pagoPublicacion');

        // die(var_dump($fechaExpiracion));

        $validator->after(function ($validator) use($iniciofecha, $finalfecha, $fechamaxima, $fechaExpiracion, $now, $pagoRequerimiento, $pagoPublicacion)  {

            if ($iniciofecha < $now) {
                $validator->errors()->add('inicioFecha', 'La fecha de recojo debe ser mayor a la fecha actual');
            }

            if ($finalfecha < $now) {
                $validator->errors()->add('finalFecha', 'La fecha de entrega debe ser mayor a la fecha actual');
            }

            if ($iniciofecha > $finalfecha) {
                $validator->errors()->add('finalFecha', 'La fecha de entrega debe ser mayor a la fecha de recojo ');
            }

            if ($fechamaxima > $iniciofecha) {
                $validator->errors()->add('maximaFecha', 'La fecha maxima debe ser menor a la fecha de recojo ');
            }

             if ($fechamaxima > $finalfecha) {
                $validator->errors()->add('maximaFecha', 'La fecha maxima debe ser menor a la fecha de entrega ');
            }

            if ($fechamaxima < $fechaExpiracion) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser menor a la fecha maxima');
            }

            if ($fechaExpiracion < $now) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser mayor a la fecha actual');
            }

            if ($pagoRequerimiento <= $pagoPublicacion ) {
                $validator->errors()->add('pagoMonto', 'El pago de la publicacion debe ser menor al del requerimiento');
            }
        });

        if ($request->get('cantDias') == "") {
            $cantDias = "0";
        } else {
            $cantDias = $request->get('cantDias');
        }

        if (!$validator->fails()) {

            $publicacion = Publicacion::find($id);  
            $publicacion->pagomonto = $pagoPublicacion;
            $publicacion->fechaexpiracion = $fechaExpiracion;
            $publicacion->save();

            $requerimiento = GenRequerimiento::find($publicacion->requerimiento->id);
            $requerimiento->producto = $request->get('producto');
            $requerimiento->pesoneto = $request->get('pesoNeto');
            $requerimiento->pesounidad = $request->get('pesoUnidad');
            $requerimiento->iniciod_id = $request->get('iniciodistrito');
            $requerimiento->iniciodireccion = $request->get('inicioDireccion');
            $requerimiento->iniciofecha = $iniciofecha;
            $requerimiento->finald_id = $request->get('finaldistrito');
            $requerimiento->finaldireccion = $request->get('finalDireccion');
            $requerimiento->finalfecha = $request->get('finalFecha');
            $requerimiento->maximafecha = $fechamaxima;
            $requerimiento->unidadcantidad = $request->get('unidadCantidad');
            $requerimiento->unidadrequisito = $request->get('unidadRequisito');
            $requerimiento->unidadtipo = $request->get('unidadTipo');
            $requerimiento->pagometodo = $request->get('pagoMetodo');
            $requerimiento->pagomoneda = $request->get('pagoMoneda');
            $requerimiento->pagomonto = $request->get('pagoMonto');
            $requerimiento->cantdias = $cantDias;
            $requerimiento->igv = $request->get('igv') ? 1 : 0;
            $requerimiento->seguro = $request->get('seguro') ? 1 : 0;
            $requerimiento->portn = $request->get('porTn') ? 1 : 0;
            $requerimiento->save();

        }

        return response()->json($validator->messages(), 200);
    }

    public function updateM(Request $request, $id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');
        
        $rules = [
            'inicioFecha' => 'required|date_format:"Y-m-d',
            'inicioHora' => 'required|date_format:"H:i',
            'finalFecha' => 'required|date_format:"Y-m-d',
            'maximaFecha' => 'required|date_format:"Y-m-d',
            'maximaHora' => 'required|date_format:"H:i',
            'expiracionFecha' => 'required|date_format:"Y-m-d',
            'expiracionHora' => 'required|date_format:"H:i',
        ];

        $messages = array(
            'inicioFecha.required' => 'Es necesario ingresar la fecha de recojo',
            'inicioHora.required' => 'Es necesario ingresar la hora de recojo',
            'finalFecha.required' => 'Es necesario ingresar la fecha de entrega',
            'maximaFecha.required' => 'Es necesario ingresar la maxima fecha de busqueda',
            'maximaHora.required' => 'Es necesario ingresar la maxima hora de busqueda',

            'inicioFecha.date_format' => 'El formato de la fecha de recojo no es valido',
            'inicioHora.date_format' => 'El formato de la hora de recojo no es valido',
            'finalFecha.date_format' => 'El formato de la fecha de entrega no es valido',
            'maximaFecha.date_format' => 'El formato de la fecha maxima no es valido',
            'maximaHora.date_format' => 'El formato de la hora maxima no es valido',

            'expiracionFecha.required' => 'Es necesario ingresar la fecha de expiracion',
            'expiracionHora.required' => 'Es necesario ingresar la hora de expiracion',

            'expiracionFecha.date_format' => 'El formato de la fecha de expiracion no es valido',
            'expiracionHora.date_format' => 'El formato de la hora de expiracion no es valido'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        $now = Carbon::now()->toDateTimeString();
        $iniciofecha = $request->get('inicioFecha').' '.$request->get('inicioHora');
        $finalfecha = $request->get('finalFecha').' 00:00';
        $fechamaxima = $request->get('maximaFecha').' '.$request->get('maximaHora');

        $fechaExpiracion = $request->get('expiracionFecha').' '.$request->get('expiracionHora');

        $pagoRequerimiento = $request->get('pagoMonto');
        $pagoPublicacion = $request->get('pagoPublicacion');

        // die(var_dump($fechaExpiracion));

        $validator->after(function ($validator) use($iniciofecha, $finalfecha, $fechamaxima, $fechaExpiracion, $now, $pagoRequerimiento, $pagoPublicacion)  {

            if ($iniciofecha < $now) {
                $validator->errors()->add('inicioFecha', 'La fecha de recojo debe ser mayor a la fecha actual');
            }

            if ($finalfecha < $now) {
                $validator->errors()->add('finalFecha', 'La fecha de entrega debe ser mayor a la fecha actual');
            }

            if ($iniciofecha > $finalfecha) {
                $validator->errors()->add('finalFecha', 'La fecha de entrega debe ser mayor a la fecha de recojo ');
            }

            if ($fechamaxima > $iniciofecha) {
                $validator->errors()->add('maximaFecha', 'La fecha maxima debe ser menor a la fecha de recojo ');
            }

             if ($fechamaxima > $finalfecha) {
                $validator->errors()->add('maximaFecha', 'La fecha maxima debe ser menor a la fecha de entrega ');
            }

            if ($fechamaxima < $fechaExpiracion) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser menor a la fecha maxima');
            }

            if ($fechaExpiracion < $now) {
                $validator->errors()->add('expiracionFecha', 'La fecha de expiracion debe ser mayor a la fecha actual');
            }

        });


        if (!$validator->fails()) {

            $publicacion = Publicacion::find($id);  
            $publicacion->fechaexpiracion = $fechaExpiracion;
            $publicacion->estado = 'Postulando';
            $publicacion->save();

            $requerimiento = GenRequerimiento::find($publicacion->requerimiento->id);
            $requerimiento->iniciofecha = $iniciofecha;
            $requerimiento->finalfecha = $request->get('finalFecha');
            $requerimiento->maximafecha = $fechamaxima;
            $requerimiento->save();

        }

        return response()->json($validator->messages(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publication  $publication
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $rules = array(
            'id' => 'exists:publicacions'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $publicacion = Publicacion::find($request->get('id'));
            $publicacion->eliminado = 1;
            $publicacion->save();

            $idrequerimiento = $publicacion->gen_requerimiento_id;
            $requerimiento = GenRequerimiento::find($idrequerimiento);
            $requerimiento->estado = 'Nuevo';
            $requerimiento->save();

            return response()->json($idrequerimiento);
        }

        return response()->json($validator->messages(), 200);
    }

    public function deny(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $rules = array(
            'id' => 'exists:publicacions'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $npublicacion_notificacion = PublicacionVisto::where('publicacion_id',$request->get('id'))
                                                    ->where('empresa_tran_id', Auth::user()->empresa->id)
                                                    ->first();
            $npublicacion_notificacion->notificacion = 1;
            $npublicacion_notificacion->visto = 1;
            $npublicacion_notificacion->save();
        }

        return response()->json($validator->messages(), 200);
    }
}
