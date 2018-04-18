@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>REGISTRAR EMPRESA GENERADORA DE CARGA</b></div>


                <div class="panel-body">

                    <form class="form-horizontal" method="POST" id="form-reg-generador" action="{{ url('/generador/registro') }}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Acceso</b></legend>
                            
                            <div class="form-group">
                                <label for="email" class="col-md-3 control-label" >E-mail:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="email" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password" class="col-md-3 control-label" >Contraseña:</label>

                                <div class="col-md-8">
                                    <input type="password" class="form-control" name="password" autofocus> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos Empresariales</b></legend>
                            
                            <div class="form-group">
                                <label for="ruc" class="col-md-3 control-label" >RUC:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="ruc" autofocus maxlength="11"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="razonSocial" class="col-md-3 control-label" >Razon Social:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="razonSocial" autofocus> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Contacto</b></legend>
                            
                            <div class="form-group">
                                <label for="contNombre" class="col-md-3 control-label" >Nombres Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contNombre" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contApellido" class="col-md-3 control-label" >Apellidos Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contApellido" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contTelefono" class="col-md-3 control-label" >Telefono Principal:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="contTelefono" autofocus> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Datos de Encargado de Pago</b></legend>
                            
                            <div class="form-group">
                                <label for="encargNombre" class="col-md-3 control-label" >Nombres Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="encargNombre" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="encargApellido" class="col-md-3 control-label" >Apellidos Completos:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="encargApellido" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="encargTelefono" class="col-md-3 control-label" >Telefono Principal:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="encargTelefono" autofocus> 
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
                                            <option value="{{$departamento->id}}">{{$departamento->descripcion}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="provincia" class="col-md-3 control-label" >Provincia:</label>

                                <div class="col-md-8">
                                    <select class="form-control" id="select-provincia">
                                        <option value="">Seleccione provincia</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="distrito" class="col-md-3 control-label" >distrito:</label>

                                <div class="col-md-8">
                                    <select class="form-control" name="distrito" id="select-distrito">
                                        <option value="">Seleccione distrito</option>
                                    </select>
                                </div>
                            </div>  

                            <div class="form-group">
                                <label for="direccion" class="col-md-3 control-label" >Direccion:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="direccion" autofocus> 
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar empresa
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
    <script src="{{ asset('/js/Empresa/generador.js') }}"></script>
@endsection

