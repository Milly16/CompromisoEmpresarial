<?php

namespace App\Http\Controllers;

use App\Modelo\UnidadTrabajador\TranUnidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TranUnidadController extends Controller
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

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $unidades = TranUnidad::with('empresatran')
                        ->where('empresa_tran_id', Auth::user()->empresa->id)
                        ->where('eliminado', 0)
                        ->orderBy('id', 'desc')
                        ->paginate(3);

        return view('Unidad-Trabajador.unidad.listado')->with(compact('unidades'));
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

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        return view('Unidad-Trabajador.unidad.nuevo');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $rules = [
            'tipo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'anio' => 'required|integer|digits:4|min:0',
            'mtcTracto' => 'required|unique:tran_unidads,mtctracto',
            'placaTracto' => 'required',
            'mtcCarreta' => 'required',
            'placaCarreta' => 'required',
            'fechaSoat' => 'required|date_format:"Y-m-d',
            'nsoat' => 'required|integer|min:0',
            'largo' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
            'ancho' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
            'alto' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
            'pesoBruto' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
        ];

        $messages = array(
            'tipo.required' => 'Es necesario ingresar el tipo',
            'marca.required' => 'Es necesario ingresar la marca',
            'modelo.required' => 'Es necesario ingresar el modelo',
            'color.required' => 'Es necesario ingresar el color',
            'anio.required' => 'Es necesario ingresar el año',
            'mtcTracto.required' => 'Es necesario ingresar el mtc del tracto',
            'placaTracto.required' => 'Es necesario ingresar la placa del tracto',
            'mtcCarreta.required' => 'Es necesario ingresar el mtc de la carreta',
            'placaCarreta.required' => 'Es necesario ingresar la placa de la carreta',
            'fechaSoat.required' => 'Es necesario ingresar la fecha del SOAT',
            'nsoat.required' => 'Es necesario ingresar el numero del SOAT',
            'largo.required' => 'Es necesario ingresar el largo',
            'ancho.required' => 'Es necesario ingresar el ancho',
            'alto.required' => 'Es necesario ingresar el alto',
            'pesoBruto.required' => 'Es necesario ingresar el peso bruto',

            'anio.integer' => 'El año debe ser numerico',
            'nsoat.integer' => 'El numero de SOAT debe ser numerico',

            'largo.numeric' => 'El largo debe ser numerico',
            'ancho.numeric' => 'El ancho debe ser numerico',
            'alto.numeric' => 'El alto debe ser numerico',
            'pesoBruto.numeric' => 'El peso bruto debe ser numerico',

            'anio.digits:4' => 'El año debe tener 4 digitos',
            
            'anio.min:0' => 'El año debe ser positivo',
            'nsoat.min:0' => 'El numero de soat debe ser positivo',
            'largo.min:0' => 'El largo debe ser positivo',
            'ancho.min:0' => 'El ancho debe ser positivo',
            'alto.min:0' => 'El alto debe ser positivo',
            'pesoBruto.min:0' => 'El peso bruto debe ser positivo',

            'fechaSoat.date_format:"Y-m-d' => 'El formato de la fecha del SOAT no es valido',
            'largo.regex:/^\d*(\.\d{2})?$/' => 'El formato de el largo no es valido',
            'ancho.regex:/^\d*(\.\d{2})?$/' => 'El formato de el ancho no es valido',
            'alto.regex:/^\d*(\.\d{2})?$/' => 'El formato de el alto no es valido',
            'pesoBruto.regex:/^\d*(\.\d{2})?$/' => 'El formato de el peso bruto no es valido'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        if (!$validator->fails()) {

            /*die(var_dump($request->all())); */
            $unidad = TranUnidad::create([
                    'tipo' => $request->get('tipo'),
                    'marca' => $request->get('marca'),
                    'modelo' => $request->get('modelo'),
                    'color' => $request->get('color'),
                    'anio' => $request->get('anio'),
                    'mtctracto' => $request->get('mtcTracto'),
                    'placatracto' => $request->get('placaTracto'),
                    'mtccarreta' => $request->get('mtcCarreta'),
                    'placacarreta' => $request->get('placaCarreta'),
                    'fechasoat' => $request->get('fechaSoat'),
                    'nsoat' => $request->get('nsoat'),
                    'largo' => $request->get('largo'),
                    'ancho' => $request->get('ancho'),
                    'alto' => $request->get('alto'),
                    'pesobruto' => $request->get('pesoBruto'),
                    'eliminado' => 0,
                    'empresa_tran_id' => Auth::user()->empresa->id
            ]);
            $unidad->save();
         
        }


        return response()->json($validator->messages(), 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TranUnidad  $TranUnidad
     * @return \Illuminate\Http\Response
     */
    public function show(TranUnidad $TranUnidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TranUnidad  $TranUnidad
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $unidad = TranUnidad::find($id);
        if (! $unidad) 
            return redirect('/transportista/unidad/listado');

        return view('Unidad-Trabajador.unidad.editar')->with(compact('unidad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TranUnidad  $TranUnidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $rules = [
            'tipo' => 'required',
            'marca' => 'required',
            'modelo' => 'required',
            'color' => 'required',
            'anio' => 'required|integer|digits:4|min:0',
            'mtcTracto' => 'required',
            'placaTracto' => 'required',
            'mtcCarreta' => 'required',
            'placaCarreta' => 'required',
            'fechaSoat' => 'required|date_format:"Y-m-d',
            'nsoat' => 'required|integer|min:0',
            'largo' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
            'ancho' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
            'alto' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
            'pesoBruto' => 'required|numeric|min:0|regex:/^\d*(\.\d{2})?$/',
        ];

        $messages = array(
            'tipo.required' => 'Es necesario ingresar el tipo',
            'marca.required' => 'Es necesario ingresar la marca',
            'modelo.required' => 'Es necesario ingresar el modelo',
            'color.required' => 'Es necesario ingresar el color',
            'anio.required' => 'Es necesario ingresar el año',
            'mtcTracto.required' => 'Es necesario ingresar el mtc del tracto',
            'placaTracto.required' => 'Es necesario ingresar la placa del tracto',
            'mtcCarreta.required' => 'Es necesario ingresar el mtc de la carreta',
            'placaCarreta.required' => 'Es necesario ingresar la placa de la carreta',
            'fechaSoat.required' => 'Es necesario ingresar la fecha del SOAT',
            'nsoat.required' => 'Es necesario ingresar el numero del SOAT',
            'largo.required' => 'Es necesario ingresar el largo',
            'ancho.required' => 'Es necesario ingresar el ancho',
            'alto.required' => 'Es necesario ingresar el alto',
            'pesoBruto.required' => 'Es necesario ingresar el peso bruto',

            'anio.integer' => 'El año debe ser numerico',
            'nsoat.integer' => 'El numero de SOAT debe ser numerico',

            'largo.numeric' => 'El largo debe ser numerico',
            'ancho.numeric' => 'El ancho debe ser numerico',
            'alto.numeric' => 'El alto debe ser numerico',
            'pesoBruto.numeric' => 'El peso bruto debe ser numerico',

            'anio.digits:4' => 'El año debe tener 4 digitos',
            
            'anio.min:0' => 'El año debe ser positivo',
            'nsoat.min:0' => 'El numero de soat debe ser positivo',
            'largo.min:0' => 'El largo debe ser positivo',
            'ancho.min:0' => 'El ancho debe ser positivo',
            'alto.min:0' => 'El alto debe ser positivo',
            'pesoBruto.min:0' => 'El peso bruto debe ser positivo',

            'fechaSoat.date_format:"Y-m-d' => 'El formato de la fecha del SOAT no es valido',
            'largo.regex:/^\d*(\.\d{2})?$/' => 'El formato de el largo no es valido',
            'ancho.regex:/^\d*(\.\d{2})?$/' => 'El formato de el ancho no es valido',
            'alto.regex:/^\d*(\.\d{2})?$/' => 'El formato de el alto no es valido',
            'pesoBruto.regex:/^\d*(\.\d{2})?$/' => 'El formato de el peso bruto no es valido'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        if (!$validator->fails()) {

            /*die(var_dump($request->all())); */
            $unidad = TranUnidad::find($id);
            $unidad->tipo = $request->get('tipo');
            $unidad->marca = $request->get('marca');
            $unidad->modelo = $request->get('modelo');
            $unidad->color = $request->get('color');
            $unidad->anio = $request->get('anio');
            $unidad->mtctracto = $request->get('mtcTracto');
            $unidad->placatracto = $request->get('placaTracto');
            $unidad->mtccarreta = $request->get('mtcCarreta');
            $unidad->placacarreta = $request->get('placaCarreta');
            $unidad->fechasoat = $request->get('fechaSoat');
            $unidad->nsoat = $request->get('nsoat');
            $unidad->largo = $request->get('largo');
            $unidad->ancho = $request->get('ancho');
            $unidad->alto = $request->get('alto');
            $unidad->pesobruto = $request->get('pesoBruto');
            $unidad->save();
        }

        return response()->json($validator->messages(), 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TranUnidad  $TranUnidad
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $rules = array(
            'id' => 'exists:tran_unidads'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $unidad = TranUnidad::find($request->get('id'));
            $unidad->eliminado = 1;
            $unidad->save();
        }

        return response()->json($validator->messages(), 200);
    }

    public function details($id)
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $unidad = TranUnidad::find($id);
        if (! $unidad) 
            return redirect('/transportista/unidad/listado');

        return view('Unidad-Trabajador.unidad.detalle')->with(compact('unidad'));
    }
}
