@extends('layouts.appT')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>DETALLE DE UNIDAD</b></div>


                <div class="panel-body panel-details">
                    <fieldset>
                        <legend  style="font-size: 15px;"><b>Especificaciones</b></legend>
                            
                        <div class="form-group col-md-12">
                            <label for="tipo" class="col-md-1 control-label" >Tipo:</label>

                            <div class="col-md-10 input-move">
                                {{ $unidad->tipo }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="marca" class="col-md-3 control-label" >Marca:</label>

                            <div class="col-md-9">
                                {{ $unidad->marca }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="modelo" class="col-md-3 control-label" >Modelo:</label>

                            <div class="col-md-9">
                                {{ $unidad->modelo }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="color" class="col-md-3 control-label" >Color:</label>

                            <div class="col-md-9">
                                {{ $unidad->color }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="anio" class="col-md-3 control-label" >Año:</label>

                            <div class="col-md-9">
                                {{ $unidad->anio }}
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend  style="font-size: 15px;"><b>Tracto</b></legend>
                            
                        <div class="form-group col-md-6">
                            <label for="mtcTracto" class="col-md-3 control-label" >MTC:</label>

                            <div class="col-md-9">
                                {{ $unidad->mtctracto }}
                            </div>
                        </div>

                            <div class="form-group col-md-6">
                            <label for="placaTracto" class="col-md-3 control-label" >Placa:</label>

                            <div class="col-md-9">
                                {{ $unidad->placatracto }}
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend  style="font-size: 15px;"><b>Carreta</b></legend>
                            
                        <div class="form-group col-md-6">
                            <label for="mtcCarreta" class="col-md-3 control-label" >MTC:</label>

                            <div class="col-md-9">
                                {{ $unidad->mtccarreta }}
                            </div>
                        </div>

                            <div class="form-group col-md-6">
                            <label for="placaCarreta" class="col-md-3 control-label" >Placa:</label>

                            <div class="col-md-9">
                                {{ $unidad->placacarreta }}
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend  style="font-size: 15px;"><b>SOAT</b></legend>
                            
                        <div class="form-group col-md-6">
                            <label for="fechaSoat" class="col-md-3 control-label" >Fecha:</label>

                            <div class="col-md-9">
                                {{\Carbon\Carbon::parse($unidad->fechaSoat)->format('d-m-Y')}}
                            </div>
                        </div>

                            <div class="form-group col-md-6">
                            <label for="nsoat" class="col-md-3 control-label" >Numero:</label>

                            <div class="col-md-9">
                                {{ $unidad->nsoat }}
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend  style="font-size: 15px;"><b>Dimensiones y Peso</b></legend>
                            
                        <div class="form-group col-md-6">
                            <label for="largo" class="col-md-3 control-label" >Largo:</label>

                            <div class="col-md-9">
                                {{ $unidad->largo }} metros
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="ancho" class="col-md-3 control-label" >Ancho:</label>

                            <div class="col-md-9">
                                {{ $unidad->ancho }} metros
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="alto" class="col-md-3 control-label" >Alto:</label>

                            <div class="col-md-9">
                                {{ $unidad->alto }} metros
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="  pesoBruto" class="col-md-4 control-label" >Peso Bruto:</label>

                            <div class="col-md-8">
                                {{ $unidad->pesobruto }} Tn
                            </div>
                        </div>
                    </fieldset>     
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="{{ asset('/js/Unidad-Trabajador/unidad.js') }}"></script>
@endsection

