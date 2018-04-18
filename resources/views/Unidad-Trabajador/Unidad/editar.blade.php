@extends('layouts.appT')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>EDITAR NUEVA UNIDAD</b></div>


                <div class="panel-body">

                    <form class="form-horizontal" method="POST" id="form-edit-unidad" action="{{ url('/unidad/editar').'/'.$unidad->id }}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Especificaciones</b></legend>
                            
                            <div class="form-group col-md-12">
                                <label for="tipo" class="col-md-1 control-label" >Tipo:</label>

                                <div class="col-md-10 input-move">
                                    <input type="text" class="form-control" name="tipo" autofocus value="{{ $unidad->tipo }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="marca" class="col-md-3 control-label" >Marca:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="marca" autofocus value="{{ $unidad->marca }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="modelo" class="col-md-3 control-label" >Modelo:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="modelo" autofocus value="{{ $unidad->modelo }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="color" class="col-md-3 control-label" >Color:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="color" autofocus value="{{ $unidad->color }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="anio" class="col-md-3 control-label" >Año:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="anio" autofocus maxlength="4" value="{{ $unidad->anio }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Tracto</b></legend>
                            
                            <div class="form-group col-md-6">
                                <label for="mtcTracto" class="col-md-3 control-label" >MTC:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="mtcTracto" autofocus value="{{ $unidad->mtctracto }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="placaTracto" class="col-md-3 control-label" >Placa:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="placaTracto" autofocus value="{{ $unidad->placatracto }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Carreta</b></legend>
                            
                            <div class="form-group col-md-6">
                                <label for="mtcCarreta" class="col-md-3 control-label" >MTC:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="mtcCarreta" autofocus value="{{ $unidad->mtccarreta }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="placaCarreta" class="col-md-3 control-label" >Placa:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="placaCarreta" autofocus value="{{ $unidad->placacarreta }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>SOAT</b></legend>
                            
                            <div class="form-group col-md-6">
                                <label for="fechaSoat" class="col-md-3 control-label" >Fecha:</label>

                                <div class="col-md-9">
                                    <input type="date" class="form-control" name="fechaSoat" autofocus value="{{ $unidad->fechasoat }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nsoat" class="col-md-3 control-label" >Numero:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nsoat" autofocus value="{{ $unidad->nsoat }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Dimensiones y Peso</b></legend>
                            
                            <div class="form-group col-md-6">
                                <label for="largo" class="col-md-3 control-label" >Largo:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="largo" autofocus value="{{ $unidad->largo }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="ancho" class="col-md-3 control-label" >Ancho:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="ancho" autofocus value="{{ $unidad->ancho }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="alto" class="col-md-3 control-label" >Alto:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="alto" autofocus value="{{ $unidad->alto }}"> 
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="  pesoBruto" class="col-md-4 control-label" >Peso Bruto:</label>

                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="pesoBruto" autofocus value="{{ $unidad->pesobruto }}"> 
                                </div>
                            </div>
                        </fieldset>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Editar Unidad
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
    <script src="{{ asset('/js/Unidad-Trabajador/unidad.js') }}"></script>
@endsection

