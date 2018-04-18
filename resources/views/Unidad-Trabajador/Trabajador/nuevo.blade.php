@extends('layouts.appT')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>REGISTRAR NUEVO TRABAJADOR</b></div>


                <div class="panel-body">

                    <form class="form-horizontal" method="POST" id="form-reg-trabajador" action="{{ url('/trabajador/nuevo') }}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle del trabajador</b></legend>
                            
                            <div class="form-group">
                                <label for="dni" class="col-md-3 control-label" >DNI:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="dni" autofocus maxlength="8"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="nombre" class="col-md-3 control-label" >Nombre:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="nombre" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="apellido" class="col-md-3 control-label" >Apellido:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="apellido" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="celular" class="col-md-3 control-label" >Celular:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="celular" autofocus maxlength="9"> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="direccion" class="col-md-3 control-label" >Direccion:</label>

                                <div class="col-md-8"> 
                                    <input type="text" class="form-control" name="direccion" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fechNacimiento" class="col-md-3 control-label" >Fecha de nacimiento:</label>

                                <div class="col-md-8"> 
                                    <input type="date" class="form-control" name="fechNacimiento" autofocus> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="brevete" class="col-md-3 control-label" >Brevete:</label>

                                <div class="col-md-8"> 
                                    <input type="text" class="form-control" name="brevete" autofocus> 
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar trabajador
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
    <script src="{{ asset('/js/Unidad-Trabajador/trabajador.js') }}"></script>
@endsection

