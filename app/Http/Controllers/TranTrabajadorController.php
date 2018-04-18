<?php

namespace App\Http\Controllers;

use App\Modelo\UnidadTrabajador\TranTrabajador;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TranTrabajadorController extends Controller
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

        $trabajadores = TranTrabajador::with('empresatran')
                        ->where('empresa_tran_id', Auth::user()->empresa->id)
                        ->where('eliminado', 0)
                        ->orderBy('id', 'desc')
                        ->paginate(3);

        return view('Unidad-Trabajador.trabajador.listado')->with(compact('trabajadores'));
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

        return view('Unidad-Trabajador.trabajador.nuevo');
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
            'dni' => 'required|integer|digits:8|unique:tran_trabajadors,dni|min:0',
            'nombre' => 'required',
            'apellido' => 'required',
            'celular' => 'required|integer|digits:9|min:0',
            'fechNacimiento' => 'required|date_format:"Y-m-d',
            'brevete' => 'required|unique:tran_trabajadors,brevete',
            'direccion' => 'required'
        ];

        $messages = array(
            'dni.required' => 'Es necesario ingresar el DNI',
            'nombre.required' => 'Es necesario ingresar el nombre',
            'apellido.required' => 'Es necesario seleccionar el apellido', 
            'celular.required' => 'Es necesario ingresar el celular', 
            'fechNacimiento.required' => 'Es necesario ingresar la fecha de nacimiento',
            'brevete.required' => 'Es necesario ingresar el brevete',
            'direccion.required' => 'Es necesario ingresar la direccion',
            
            'dni.digits' => 'El dni debe tener 8 digitos',
            'celular.digits' => 'El celular debe tener 9 digitos',

            'dni.integer' => 'El DNI debe ser numerico',
            'celular.integer' => 'El celular debe ser numerico',
            
            'celular.min' => 'El celular debe ser positivo',            
            'dni.min' => 'El dni debe ser positivo',            

            'fechNacimiento.date_format' => 'El formato de la fecha de recojo no es valido',

            'dni.unique' => 'Ya existe DNI de trabajador',
            'brevete.unique' => 'Ya existe brevete'
        );     

        $validator = Validator::make($request->all(), $rules,$messages);

        if (!$validator->fails()) {

            /*die(var_dump($request->all())); */
            $trabajador = TranTrabajador::create([
                    'dni' => $request->get('dni'),
                    'nombre' => $request->get('nombre'),
                    'apellido' => $request->get('apellido'),
                    'celular' => $request->get('celular'),
                    'nacimiento' => $request->get('fechNacimiento'),
                    'brevete' => $request->get('brevete'),
                    'direccion' => $request->get('direccion'),
                    'eliminado' => 0,
                    'empresa_tran_id' => Auth::user()->empresa->id
            ]);
            $trabajador->save();
         
        }


        return response()->json($validator->messages(), 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TransWorker  $transWorker
     * @return \Illuminate\Http\Response
     */
    public function show(TransWorker $transWorker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TransWorker  $transWorker
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

        $trabajador = TranTrabajador::find($id);
        if (! $trabajador) 
            return redirect('/transportista/trabajador/listado');

        return view('Unidad-Trabajador.trabajador.editar')->with(compact('trabajador'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TransWorker  $transWorker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

         $rules = [
            'dni' => 'required|integer|digits:8|min:0',
            'nombre' => 'required',
            'apellido' => 'required',
            'celular' => 'required|integer|digits:9|min:0',
            'fechNacimiento' => 'required|date_format:"Y-m-d',
            'brevete' => 'required',
            'direccion' => 'required'
        ];

        $messages = array(
            'dni.required' => 'Es necesario ingresar el DNI',
            'nombre.required' => 'Es necesario ingresar el nombre',
            'apellido.required' => 'Es necesario seleccionar el apellido', 
            'celular.required' => 'Es necesario ingresar el celular', 
            'fechNacimiento.required' => 'Es necesario ingresar la fecha de nacimiento',
            'brevete.required' => 'Es necesario ingresar el brevete',
            'direccion.required' => 'Es necesario ingresar la direccion',
            
            'dni.digits' => 'El dni debe tener 8 digitos',
            'celular.digits' => 'El celular debe tener 9 digitos',

            'dni.integer' => 'El DNI debe ser numerico',
            'celular.integer' => 'El celular debe ser numerico',
            
            'celular.min' => 'El celular debe ser positivo',            
            'dni.min' => 'El dni debe ser positivo',            

            'fechNacimiento.date_format' => 'El formato de la fecha de recojo no es valido',
        );        

        $validator = Validator::make($request->all(), $rules,$messages);

        if (!$validator->fails()) {

            /*die(var_dump($request->all())); */
            $trabajador = TranTrabajador::find($id);
            $trabajador->dni = $request->get('dni');
            $trabajador->nombre = $request->get('nombre');
            $trabajador->apellido = $request->get('apellido');
            $trabajador->celular = $request->get('celular');
            $trabajador->nacimiento = $request->get('fechNacimiento');
            $trabajador->brevete = $request->get('brevete');
            $trabajador->direccion = $request->get('direccion');
            $trabajador->save();
         
        }

        return response()->json($validator->messages(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TransWorker  $transWorker
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');

         $rules = array(
            'id' => 'exists:tran_trabajadors'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $trabajador = TranTrabajador::find($request->get('id'));
            $trabajador->eliminado = 1;
            $trabajador->save();
        }

        return response()->json($validator->messages(), 200);
    }

    public function getTrabajadores($id)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 3)
            return redirect('home');
        
        return TranTrabajador::where('id',$id)->get();
    }
}
