<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Modelo\Requerimiento\GenRequerimiento;
use App\Modelo\Ubigeo\Departamento;
use App\Modelo\Ubigeo\Distrito;
use App\Modelo\Ubigeo\Provincia;
use App\Modelo\Usuario\Usuario;
use App\Modelo\Empresa\Empresa;
use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

class GenRequerimientoController extends Controller
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
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 2)
            return redirect('home');
        

        $departamentos = Departamento::all();
        return view('Requerimiento.nuevo')->with(compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
            'pagoMonto' => 'required|min:1'
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
            'maximaHora.date_format' => 'El formato de la hora maxima no es valido'

        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        $now = Carbon::now()->toDateTimeString();
        $iniciofecha = $request->get('inicioFecha').' '.$request->get('inicioHora');
        $finalfecha = $request->get('finalFecha').' 00:00';
        $fechamaxima = $request->get('maximaFecha').' '.$request->get('maximaHora');
       

        /*die(var_dump($request->get('igv') ? '1' : '0'));*/

       /* die(var_dump($cantDias));*/       
        
        $validator->after(function ($validator) use($now, $iniciofecha, $finalfecha, $fechamaxima)  {

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
        });

        if ($request->get('cantDias') == "") {
            $cantDias = "0";
        } else {
            $cantDias = $request->get('cantDias');
        }

         if (!$validator->fails()) {

            /*dd($request->all());  */ 
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
                    'estado' => 'Nuevo',
                    'empresa_gen_id' => Auth::user()->empresa->id,
                    'creadofecha' => Carbon::now()->toDateTimeString()
            ]);
            $requerimiento->save();
        }

         return response()->json($validator->messages(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\GenRequest  $genRequest
     * @return \Illuminate\Http\Response
     */
    public function detailsG($id)
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 2)
            return redirect('home');

        $requerimiento = GenRequerimiento::find($id);
        if (! $requerimiento) 
            return redirect('/Requerimiento/listado');

        $texto=$requerimiento->unidadrequisito; 
        $texto=preg_replace("/\n+/","\n",$texto); 
        $lineas=explode("\n",$texto); 

        $inicio= $requerimiento->iniciodireccion.','.$requerimiento->iniciod->descripcion;
        $final= $requerimiento->finaldireccion.','.$requerimiento->finald->descripcion;

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

        return view('Requerimiento.detalle')->with(compact('requerimiento','lineas', 'distancia', 'tiempo'));
    }

    public function detailsA($id)
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $nrequerimiento = GenRequerimiento::find($id);
        $nrequerimiento->visto = 1;
        $nrequerimiento->save();

        if (! $nrequerimiento) 
            return redirect('/home');

        $inicio= $nrequerimiento->iniciodireccion.','.$nrequerimiento->iniciod->descripcion;
        $final= $nrequerimiento->finaldireccion.','.$nrequerimiento->finald->descripcion;

        $texto=$nrequerimiento->unidadRequisito; 
        $texto=preg_replace("/\n+/","\n",$texto); 
        $lineas=explode("\n",$texto); 

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

        


        return view('Publicacion.nrequerimientodetalle')->with(compact('nrequerimiento','lineas', 'distancia', 'tiempo', 'galon'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\GenRequest  $genRequest
     * @return \Illuminate\Http\Response
     */
    

    public function edit($id)
    {
        $requerimiento = GenRequerimiento::find($id);        
        if (!$requerimiento) 
            return redirect('/home');

        if ($requerimiento->estado != 'Nuevo') 
            return redirect('/home');

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 2)
            return redirect('home');
        
        $departamentos = Departamento::all();

        $i_departamento = $requerimiento->iniciod->provincia->departamento_id;
        $i_provincias = Provincia::all()
                        ->where('departamento_id', $i_departamento); 

        $i_provincia = $requerimiento->iniciod->provincia_id;
        $i_distritos = Distrito::all()
                        ->where('provincia_id', $i_provincia); 

        $f_departamento = $requerimiento->finald->provincia->departamento_id;
        $f_provincias = Provincia::all()
                        ->where('departamento_id', $f_departamento);  

        $f_provincia = $requerimiento->finald->provincia_id;
        $f_distritos = Distrito::all()
                        ->where('provincia_id', $f_provincia); 

        /*dd($i_distritos);*/

        return view('Requerimiento.editar')->with(compact('requerimiento', 'departamentos', 'i_provincias', 'i_distritos', 'f_provincias', 'f_distritos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GenRequest  $genRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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
            'unidadCantidad' => 'required',
            'unidadTipo' => 'required',
            'unidadRequisito' => 'required',
            'pagoMetodo' => 'required|in:contado,credito',
            'pagoMoneda' => 'required|in:sol,dol',
            'pagoMonto' => 'required'
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
            'maximaHora.date_format' => 'El formato de la hora maxima no es valido'

        );     



        $validator = Validator::make($request->all(), $rules,$messages);

        $now = Carbon::now()->toDateTimeString();
        $iniciofecha = $request->get('inicioFecha').' '.$request->get('inicioHora');
        $finalfecha = $request->get('finalFecha').' 00:00';
        $fechamaxima = $request->get('maximaFecha').' '.$request->get('maximaHora');
       

        /*die(var_dump($request->get('igv') ? '1' : '0'));*/

       /* die(var_dump($cantDias));*/       
        
        $validator->after(function ($validator) use($now, $iniciofecha, $finalfecha, $fechamaxima)  {

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
        });

        if ($request->get('cantDias') == "") {
            $cantDias = "0";
        } else {
            $cantDias = $request->get('cantDias');
        }

        if (!$validator->fails()) {

            /*dd($request->all());  */ 
            /*die(var_dump($id));*/
            $requerimiento = GenRequerimiento::find($id);
            $requerimiento->producto = $request->get('producto');
            $requerimiento->pesoNeto = $request->get('pesoNeto');
            $requerimiento->pesoUnidad = $request->get('pesoUnidad');
            $requerimiento->iniciod_id = $request->get('iniciodistrito');
            $requerimiento->inicioDireccion = $request->get('inicioDireccion');
            $requerimiento->inicioFecha = $iniciofecha;
            $requerimiento->finald_id = $request->get('finaldistrito');
            $requerimiento->finalDireccion = $request->get('finalDireccion');
            $requerimiento->finalFecha = $request->get('finalFecha');
            $requerimiento->maximaFecha = $fechamaxima;
            $requerimiento->unidadCantidad = $request->get('unidadCantidad');
            $requerimiento->unidadRequisito = $request->get('unidadRequisito');
            $requerimiento->unidadTipo = $request->get('unidadTipo');
            $requerimiento->pagoMetodo = $request->get('pagoMetodo');
            $requerimiento->pagoMoneda = $request->get('pagoMoneda');
            $requerimiento->pagoMonto = $request->get('pagoMonto');
            $requerimiento->cantDias = $cantDias;
            $requerimiento->igv = $request->get('igv') ? 1 : 0;
            $requerimiento->seguro = $request->get('seguro') ? 1 : 0;
            $requerimiento->porTn = $request->get('porTn') ? 1 : 0;
            $requerimiento->estado = 'Nuevo';
            $requerimiento->empresa_gen_id = Auth::user()->empresa->id;
            $requerimiento->save();
        }

         return response()->json($validator->messages(), 200);
        /*$genrequest = GenRequest::find($id);
        die(var_dump($genrequest));*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GenRequest  $genRequest
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        

        $rules = array(
            'id' => 'exists:gen_requerimientos'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $requerimiento = GenRequerimiento::find($request->get('id'));
            $requerimiento->eliminado = 1;
            $requerimiento->save();
        }

        return response()->json($validator->messages(), 200);
    }

    public function deny(Request $request)
    {
        

        $rules = array(
            'id' => 'exists:gen_requerimientos'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $requerimiento = GenRequerimiento::find($request->get('id'));
            $requerimiento->estado = 'Rechazado';
            $requerimiento->save();
        }

        return response()->json($validator->messages(), 200);
    }
}
