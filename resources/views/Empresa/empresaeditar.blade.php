@extends('layouts.appG')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>EDITAR EMPRESA </b></div>


                <div class="panel-body">
                    @if($empresa->tipo_usuario_id == 2) <form class="form-horizontal" method="POST" id="form-edit-generador" action="{{ url('/generador/editar').'/'.$empresa->id }}">
                    @else <form class="form-horizontal" method="POST" id="form-edit-transportista" action="{{ url('/transportista/editar').'/'.$empresa->id }}">
                    @endif
                    
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Acceso</b></legend>
                            
                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label" >E-mail:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="email" autofocus value="{{ $empresa->email }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label" >Contraseña:</label>

                                <div class="col-md-7">
                                    <input type="password" class="form-control" name="password" autofocus readonly="readonly"> 
                                </div>

                                <div class="col-md-2">
                                    <button class="btn btn-info" id="activar">Activar</button> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos Empresariales</b></legend>
                            
                            <div class="form-group">
                                <label for="ruc" class="col-md-3 control-label" >RUC:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="ruc" autofocus maxlength="11" value="{{ $empresa->empresa->ruc }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="razonSocial" class="col-md-3 control-label" >Razon Social:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="razonSocial" autofocus value="{{ $empresa->empresa->razonsocial }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Contacto</b></legend>
                            
                            <div class="form-group">
                                <label for="contNombre" class="col-md-3 control-label" >Nombres Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contNombre" autofocus value="{{ $empresa->empresa->contnombre }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contApellido" class="col-md-3 control-label" >Apellidos Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contApellido" autofocus value="{{ $empresa->empresa->contapellido }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contTelefono" class="col-md-3 control-label" >Telefono Principal:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contTelefono" autofocus value="{{ $empresa->empresa->conttelefono }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Encargado de Pago</b></legend>
                            
                            <div class="form-group">
                                <label for="encargNombre" class="col-md-3 control-label" >Nombres Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="encargNombre" autofocus value="{{ $empresa->empresa->empresa_gen->encargnombre }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="encargApellido" class="col-md-3 control-label" >Apellidos Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="encargApellido" autofocus value="{{ $empresa->empresa->empresa_gen->encargapellido }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="encargTelefono" class="col-md-3 control-label" >Telefono Principal:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="encargTelefono" autofocus value="{{ $empresa->empresa->empresa_gen->encargtelefono }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Ubicación de la empresa</b></legend>
                            
                            <div class="form-group">
                                <label for="departamento" class="col-md-3 control-label" >Departamento:</label>

                                <div class="col-md-8">
                                    <select class="form-control" id="select-departamento">
                                        <option value="">Seleccione departamento</option>
                                        @foreach ($departamentos as $departamento)
                                            <option value="{{$departamento->id}}" @if ($departamento->id == old('select-departamentoo', $empresa->empresa->distrito->provincia->departamento_id ))
                                            selected="selected" @endif>{{$departamento->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="provincia" class="col-md-3 control-label" >Provincia:</label>

                                <div class="col-md-8">
                                    <select class="form-control" id="select-provincia">
                                        <option value="">Seleccione provincia</option>
                                        @foreach ($provincias as $provincia)
                                        <option value="{{$provincia->id}}" @if ($provincia->id == old('select-provincia', $empresa->empresa->distrito->provincia_id )) 
                                            selected="selected" @endif>{{$provincia->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="distrito" class="col-md-3 control-label" >distrito:</label>

                                <div class="col-md-8">
                                    <select class="form-control" name="distrito" id="select-distrito">
                                        <option value="">Seleccione distrito</option>
                                        @foreach ($distritos as $distrito)
                                        <option value="{{$distrito->id}}" @if ($distrito->id == old('select-distrito', $empresa->empresa->distrito_id )) 
                                            selected="selected" @endif>{{$distrito->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="direccion" class="col-md-3 control-label" >Direccion:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="direccion" autofocus value="{{ $empresa->empresa->direccion }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Editar empresa
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')

    @if($empresa->tipo_usuario_id == 2) <script src="{{ asset('/js/Empresa/generador.js') }}"></script>
    @else <script src=" {{ asset('/js/Empresa/transportista.js') }}"></script>
    @endif
    
@endsection

