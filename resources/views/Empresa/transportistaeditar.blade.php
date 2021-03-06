@extends('layouts.appA')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>EDITAR EMPRESA GENERADORA DE CARGA Nº {{ $transportista->empresa_id }}</b></div>


                <div class="panel-body">



                    <form class="form-horizontal" method="POST" id="form-edit-transportista" action="{{ url('transportista/editar').'/'.$transportista->empresa->id }}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Acceso</b></legend>
                            
                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label" >E-mail:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="email" autofocus value="{{ $transportista->email }}"> 
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
                                    <input type="text" class="form-control" name="ruc" autofocus maxlength="11" value="{{ $transportista->empresa->ruc }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="razonSocial" class="col-md-3 control-label" >Razon Social:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="razonSocial" autofocus value="{{ $transportista->empresa->razonsocial }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Contacto</b></legend>
                            
                            <div class="form-group">
                                <label for="contNombre" class="col-md-3 control-label" >Nombres Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contNombre" autofocus value="{{ $transportista->empresa->contnombre }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contApellido" class="col-md-3 control-label" >Apellidos Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contApellido" autofocus value="{{ $transportista->empresa->contapellido }}"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contTelefono" class="col-md-3 control-label" >Telefono Principal:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contTelefono" autofocus value="{{ $transportista->empresa->conttelefono }}"> 
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
                                            <option value="{{$departamento->id}}" @if ($departamento->id == old('select-departamentoo', $transportista->empresa->distrito->provincia->departamento_id ))
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
                                        <option value="{{$provincia->id}}" @if ($provincia->id == old('select-provincia', $transportista->empresa->distrito->provincia_id )) 
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
                                        <option value="{{$distrito->id}}" @if ($distrito->id == old('select-distrito', $transportista->empresa->distrito_id )) 
                                            selected="selected" @endif>{{$distrito->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="direccion" class="col-md-3 control-label" >Direccion:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="direccion" autofocus value="{{ $transportista->empresa->direccion }}"> 
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
    <script src="/js/Empresa/transportista.js"></script>
@endsection

