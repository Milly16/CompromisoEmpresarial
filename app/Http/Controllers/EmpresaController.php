<?php

namespace App\Http\Controllers;


use App\Modelo\Usuario\Usuario;
use App\Modelo\Empresa\Empresa;
use App\Modelo\Empresa\EmpresaGen;
use App\Modelo\Empresa\EmpresaTran;
use App\Modelo\Ubigeo\Departamento;
use App\Modelo\Ubigeo\Provincia;
use App\Modelo\Ubigeo\Distrito;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexG()
    {

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $generadores = Usuario::where('tipo_usuario_id', '2')
                        ->where('eliminado', 0)
                        ->orderBy('id', 'desc')
                        ->paginate(3);

        return view('Empresa.generadorlistado')->with(compact('generadores'));
    }

    public function indexT()
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        $transportistas = Usuario::where('tipo_usuario_id', '3')
                        ->where('eliminado', 0)
                        ->orderBy('id', 'desc')
                        ->paginate(3);

        return view('Empresa.transportistalistado')->with(compact('transportistas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createG()
    {
        if (!Auth::guest()) 
            return redirect('home');

        $departamentos = Departamento::all();
        return view('Empresa.generador')->with(compact('departamentos'));
    }

    public function createT()
    {
        if (!Auth::guest()) 
            return redirect('home');

        $departamentos = Departamento::all();
        return view('Empresa.transportista')->with(compact('departamentos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeG(Request $request)
    {

        $rules = [
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|between:6,8',
            'ruc' => 'required|numeric|digits:11',
            'razonSocial' => 'required',
            'contNombre' => 'required',
            'contApellido' => 'required',
            'contTelefono' => 'required|numeric',
            'encargNombre' => 'required',
            'encargApellido' => 'required',
            'encargTelefono' => 'required|numeric',
            'direccion' => 'required',
            'distrito' => 'required|exists:distritos,id'
        ];

        $messages = array(
            'email.required' => 'Es necesario ingresar el email',
            'password.required' => 'Es necesario ingresar la contraseña',
            'ruc.required' => 'Es necesario ingresar el ruc', 
            'razonSocial.required' => 'Es necesario ingresar la Razon Social', 
            'contNombre.required' => 'Es necesario ingresar el nombre de contacto',    
            'contApellido.required' => 'Es necesario ingresar el apellido de contacto', 
            'contTelefono.required' => 'Es necesario ingresar el telefono de contacto', 
            'encargNombre.required' => 'Es necesario ingresar el nombre del encargado', 
            'encargApellido.required' => 'Es necesario ingresar el apellido del encargado', 
            'encargTelefono.required' => 'Es necesario ingresar el telefono del encargado', 
            'direccion.required' => 'Es necesario ingresar la dirección de la empresa',
            'distrito.required' => 'Es necesario ingresar el distito',
            'email.email' => 'El formato de email es erroneo',
            'ruc.numeric' => 'El ruc debe ser numerico',
            'contTelefono.numeric' => 'El telefono del contacto debe ser numerico',
            'encargTelefono.numeric' => 'El telefono del encarado debe ser numerico',
            'distrito.exists' => 'El distrito no es valido',
            'email.unique' => 'Existe un usuario con el mismo email.',
            'password.between' => 'La contraseña debe ser entre 6 a 8 digitos',
            'ruc.digits' => 'El ruc debe tener 11 digitos'
        );
        

        $validator = Validator::make($request->all(), $rules,$messages);

        if (!$validator->fails()) {

            /*dd($request->all());  */ 
            $empresa = Empresa::create([
                    'ruc' => $request->get('ruc'),
                    'razonsocial' => $request->get('razonSocial'),
                    'contnombre' => $request->get('contNombre'),
                    'contapellido' => $request->get('contApellido'),
                    'conttelefono' => $request->get('contTelefono'),
                    'distrito_id' => $request->get('distrito'),
                    'direccion' => $request->get('direccion')
            ]);
            $empresa->save();

            $empresaG = EmpresaGen::create([
                    'id' => $empresa->id,
                    'encargnombre' => $request->get('encargNombre'),
                    'encargapellido' => $request->get('encargApellido'),
                    'encargtelefono' => $request->get('encargTelefono')
            ]);
            $empresaG->save();

            $usuario = Usuario::create([
                    'empresa_id' => $empresa->id,
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password')),
                    'tipo_usuario_id' => 2,
                    'eliminado' => '0',
                    'creadofecha' => Carbon::now()
            ]);
            $usuario->save();            
        }

        return response()->json($validator->messages(), 200);   
    }

    public function storeT(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|between:6,8',
            'ruc' => 'required|numeric|digits:11',
            'razonSocial' => 'required',
            'contNombre' => 'required',
            'contApellido' => 'required',
            'contTelefono' => 'required|numeric',
            'direccion' => 'required',
            'distrito' => 'required|exists:distritos,id',
            'archivo' => 'required'
        ];

        $messages = array(
            'email.required' => 'Es necesario ingresar el email',
            'password.required' => 'Es necesario ingresar la contraseña',
            'ruc.required' => 'Es necesario ingresar el ruc', 
            'razonSocial.required' => 'Es necesario ingresar la Razon Social', 
            'contNombre.required' => 'Es necesario ingresar el nombre de contacto',    
            'contApellido.required' => 'Es necesario ingresar el apellido de contacto', 
            'contTelefono.required' => 'Es necesario ingresar el telefono de contacto', 
            'direccion.required' => 'Es necesario ingresar la dirección de la empresa',
            'distrito.required' => 'Es necesario ingresar el distito',
            'archivo.required' => 'Es necesario ingresar el archivo',
            'email.email' => 'El formato de email es erroneo',
            'ruc.numeric' => 'El ruc debe ser numerico',
            'contTelefono.numeric' => 'El telefono del contacto debe ser numerico',
            'distrito.exists' => 'El distrito no es valido',
            'email.unique' => 'Existe un usuario con el mismo email.',
            'password.between' => 'La contraseña debe ser entre 6 a 8 digitos',
            'ruc.digits' => 'El ruc debe tener 11 digitos'
        );

        $validator = Validator::make($request->all(), $rules,$messages);

        if (!$validator->fails()) {

            
            $empresa = Empresa::create([
                    'ruc' => $request->get('ruc'),
                    'razonsocial' => $request->get('razonSocial'),
                    'contnombre' => $request->get('contNombre'),
                    'contapellido' => $request->get('contApellido'),
                    'conttelefono' => $request->get('contTelefono'),
                    'distrito_id' => $request->get('distrito'),
                    'direccion' => $request->get('direccion')
            ]);
            $empresa->save();

            $empresaT = EmpresaTran::create([
                    'id' => $empresa->id

            ]);

            if ($request->file('archivo'))
                {
                    $extension_file = $request->file('archivo')->getClientOriginalExtension();
                    $file_name_file = $empresa->id . '.' . $extension_file;

                    $path_archivo = public_path('archivos/');

                    $move_file = $request -> file('archivo');             

                    if ($move_file ->move($path_archivo, $file_name_file)) {
                        $empresaT->archivo = $file_name_file;
                        $empresaT->save(); 
                    }else{
                        $validator->after(function ($validator) use($now, $iniciofecha, $finalfecha, $fechamaxima)  {
                            $validator->errors()->add('archivo', 'No se pudo mover el archivo correctamente');
                        });
                    }
                }

            $empresaT->save();

            $usuario = Usuario::create([
                    'empresa_id' => $empresa->id,
                    'email' => $request->get('email'),
                    'password' => bcrypt($request->get('password')),
                    'tipo_usuario_id' => 3,
                    'eliminado' => '0',
                    'creadofecha' => Carbon::now()
            ]);
            $usuario->save(); 
        }

        return response()->json($validator->messages(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function editG($id)
    {
        $generador = Usuario::where('empresa_id', $id)
                    ->where('tipo_usuario_id', '2')
                    ->where('eliminado',0)
                    ->first();

        if (! $generador) 
            return redirect('/generador/listado');

        $departamentos = Departamento::all();

        $departamento = $generador->empresa->distrito->provincia->departamento_id;
        $provincias = Provincia::all()
                        ->where('departamento_id', $departamento);  

        $provincia = $generador->empresa->distrito->provincia_id;
        $distritos = Distrito::all()
                        ->where('provincia_id', $provincia); 

        return view('Empresa.generadoreditar')->with(compact('generador', 'departamentos', 'provincias', 'distritos'));
    }

    public function editT($id)
    {
        $transportista = Usuario::where('empresa_id', $id)
                    ->where('tipo_usuario_id', '3')
                    ->where('eliminado',0)
                    ->first();

        if (! $transportista) 
            return redirect('/transportista/listado');

        $departamentos = Departamento::all();

        $departamento = $transportista->empresa->distrito->provincia->departamento_id;
        $provincias = Provincia::all()
                        ->where('departamento_id', $departamento);  

        $provincia = $transportista->empresa->distrito->provincia_id;
        $distritos = Distrito::all()
                        ->where('provincia_id', $provincia); 

        return view('Empresa.transportistaeditar')->with(compact('transportista', 'departamentos', 'provincias', 'distritos'));
    }

    public function editE()
    {
       $empresa = Usuario::where('empresa_id', Auth::user()->empresa->id)
                    ->where('eliminado',0)
                    ->first();



        if (! $empresa) 
            return redirect('/transportista/listado');

        $departamentos = Departamento::all();

        $departamento = $empresa->empresa->distrito->provincia->departamento_id;
        $provincias = Provincia::all()
                        ->where('departamento_id', $departamento);  

        $provincia = $empresa->empresa->distrito->provincia_id;
        $distritos = Distrito::all()
                        ->where('provincia_id', $provincia); 

        return view('Empresa.empresaeditar')->with(compact('empresa', 'departamentos', 'provincias', 'distritos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function updateG(Request $request, $id)
    {

        ;
        $rules = [
            'email' => 'required|email',
            'ruc' => 'required|numeric|digits:11|min:0',
            'razonSocial' => 'required',
            'contNombre' => 'required',
            'contApellido' => 'required',
            'contTelefono' => 'required|numeric|min:0',
            'encargNombre' => 'required',
            'encargApellido' => 'required',
            'encargTelefono' => 'required|numeric|min:0',
            'direccion' => 'required',
            'distrito' => 'required|exists:distritos,id'
        ];

        $messages = array(
            'email.required' => 'Es necesario ingresar el email',
            'password.required' => 'Es necesario ingresar la contraseña',
            'ruc.required' => 'Es necesario ingresar el ruc', 
            'razonSocial.required' => 'Es necesario ingresar la Razon Social', 
            'contNombre.required' => 'Es necesario ingresar el nombre de contacto',    
            'contApellido.required' => 'Es necesario ingresar el apellido de contacto', 
            'contTelefono.required' => 'Es necesario ingresar el telefono de contacto', 
            'encargNombre.required' => 'Es necesario ingresar el nombre del encargado', 
            'encargApellido.required' => 'Es necesario ingresar el apellido del encargado', 
            'encargTelefono.required' => 'Es necesario ingresar el telefono del encargado', 
            'direccion.required' => 'Es necesario ingresar la dirección de la empresa',
            'distrito.required' => 'Es necesario ingresar el distito',
            'email.email' => 'El formato de email es erroneo',
            
            'ruc.numeric' => 'El ruc debe ser numerico',
            'contTelefono.numeric' => 'El telefono del contacto debe ser numerico',
            'encargTelefono.numeric' => 'El telefono del encarado debe ser numerico',
            
            'distrito.exists' => 'El distrito no es valido',
            'ruc.digits' => 'El ruc debe tener 11 digitos'
        );
        

        $validator = Validator::make($request->all(), $rules,$messages);

        $input_password = $request->get('password');

        $validator->after(function ($validator) use($input_password)  {

            if ($input_password != '') {
                if (strlen($input_password)>8 || 6>strlen($input_password)) {
                    $validator->errors()->add('password', 'Password nullo');
                }
                
            }
        });



        $id_company = Usuario::where('empresa_id', Auth::user()->empresa->id)->first();
        $pass_company = $id_company->password;

        if ($input_password != '') {
            $passwords =  bcrypt($input_password);
        } else {
            $passwords = $pass_company;
        }


        /*die(var_dump($passwords));*/


        if (!$validator->fails()) {
            $empresa = Empresa::where('id', Auth::user()->empresa->id)->first();
            $empresa->ruc = $request->get('ruc');
            $empresa->razonsocial = $request->get('razonSocial');
            $empresa->contnombre = $request->get('contNombre');
            $empresa->contapellido = $request->get('contApellido');
            $empresa->direccion = $request->get('direccion');
            $empresa->distrito_id = $request->get('distrito');
            $empresa->save();

            $empresa_gen = EmpresaGen::where('id', Auth::user()->empresa->id)->first();
            $empresa_gen->encargnombre = $request->get('encargNombre');
            $empresa_gen->encargapellido = $request->get('encargApellido');
            $empresa_gen->encargtelefono = $request->get('encargTelefono');
            $empresa_gen->save();

            $usuario = Usuario::find($id);
            $usuario->email = $request->get('email');
            $usuario->password = $passwords;
            $usuario->save();
        }

        return response()->json($validator->messages(), 200);
    }

    public function updateT(Request $request, $id)
    {
        $rules = [
            'email' => 'required|email',
            'ruc' => 'required|numeric|digits:11|min:0',
            'razonSocial' => 'required',
            'contNombre' => 'required',
            'contApellido' => 'required',
            'contTelefono' => 'required|numeric|min:0',
            'direccion' => 'required',
            'distrito' => 'required|exists:distritos,id'
        ];

        $messages = array(
            'email.required' => 'Es necesario ingresar el email',
            'password.required' => 'Es necesario ingresar la contraseña',
            'ruc.required' => 'Es necesario ingresar el ruc', 
            'razonSocial.required' => 'Es necesario ingresar la Razon Social', 
            'contNombre.required' => 'Es necesario ingresar el nombre de contacto',    
            'contApellido.required' => 'Es necesario ingresar el apellido de contacto', 
            'contTelefono.required' => 'Es necesario ingresar el telefono de contacto', 
            'direccion.required' => 'Es necesario ingresar la dirección de la empresa',
            'distrito.required' => 'Es necesario ingresar el distito',
            'email.email' => 'El formato de email es erroneo',
            
            'ruc.numeric' => 'El ruc debe ser numerico',
            'contTelefono.numeric' => 'El telefono del contacto debe ser numerico',
            
            'distrito.exists' => 'El distrito no es valido',
            'ruc.digits' => 'El ruc debe tener 11 digitos'
        );
        

        $validator = Validator::make($request->all(), $rules,$messages);

        $input_password = $request->get('password');

        $validator->after(function ($validator) use($input_password)  {

            if ($input_password != '') {
                if (strlen($input_password)>8 || 6>strlen($input_password)) {
                    $validator->errors()->add('password', 'Password nullo');
                }
                
            }
        });

        $id_company = Usuario::where('empresa_id', $id)->first();
        $pass_company = $id_company->password;

        if ($input_password != '') {
            $passwords =  bcrypt($input_password);
        } else {
            $passwords = $pass_company;
        }


        /*die(var_dump($passwords));*/


        if (!$validator->fails()) {
            $empresa = Empresa::find($id);
            $empresa->ruc = $request->get('ruc');
            $empresa->razonsocial = $request->get('razonSocial');
            $empresa->contnombre = $request->get('contNombre');
            $empresa->contapellido = $request->get('contApellido');
            $empresa->direccion = $request->get('direccion');
            $empresa->distrito_id = $request->get('distrito');
            $empresa->save();

            $usuario = Usuario::where('empresa_id', $id)->first();
            $usuario->email = $request->get('email');
            $usuario->password = $passwords;
            $usuario->save();
        }

        return response()->json($validator->messages(), 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Empresa  $empresa
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');
        
        $rules = array(
            'id' => 'exists:empresas'
        );
        
        $messsages = array(
            'id.exists'=>'No existe ',
        );
        
        $validator = Validator::make($request->all(), $rules, $messsages);

        if(!$validator->fails()) {
            $generador = Usuario::where('empresa_id', $request->get('id'))->first();
            $generador->eliminado = 1;
            $generador->save();
        }

        return response()->json($validator->messages(), 200);
    }


    public function downloadFile($file)
    {
        $pathtoFile = public_path().'/archivos/'.$file;
        return response()->download($pathtoFile);
    }
}
