@extends('layouts.appA')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>REGISTRAR NUEVA PUBLICACIÓN</b></div>


                <div class="panel-body">
                    <fieldset  class="panel-details">
                        <legend  style="font-size: 15px;"><b>Informacion Requerimiento Nº {{ $requerimiento->id }} </b></legend>
                            
                        <div class="form-group col-md-6">
                            <label for="tipo" class="col-md-3 control-label" >Carga:</label>

                            <div class="col-md-9">
                                {{ $requerimiento->producto }} 
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="marca" class="col-md-3 control-label" >Peso:</label>

                            <div class="col-md-9">
                                {{ $requerimiento->pesoneto }} {{ $requerimiento->pesounidad }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="modelo" class="col-md-3 control-label" >Recojo:</label>

                            <div class="col-md-9">
                                {{ $requerimiento->iniciod->provincia->descripcion }} - {{ $requerimiento->iniciod->provincia->departamento->descripcion }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="color" class="col-md-3 control-label" >Entrega:</label>

                            <div class="col-md-9">
                                {{ $requerimiento->finald->provincia->descripcion }} - {{ $requerimiento->finald->provincia->departamento->descripcion }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="anio" class="col-md-3 control-label" >Pago:</label>

                            <div class="col-md-9">
                                 @if ($requerimiento->pagomoneda == 'sol') S/.
                                            @else $
                                            @endif
                                            {{ $requerimiento->pagomonto }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="anio" class="col-md-3 control-label" >Unidades:</label>

                            <div class="col-md-9">
                                 {{ $requerimiento->unidadcantidad }} 
                                                @if ($requerimiento->unidadcantidad  > 1) unidades
                                                @else unidad
                                                @endif
                                - {{ $requerimiento->unidadtipo }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="color" class="col-md-3 control-label" >Fecha Maxima:</label>

                            <div class="col-md-9">
                                {{ \Carbon\Carbon::parse($requerimiento->maximafecha)->format('d-m-Y G:i')}}
                            </div>
                        </div>
                    </fieldset>

                    <form class="form-horizontal" method="POST" id="form-reg-publicacion" action="{{ url('/publicacion/nuevo/').'/'.$requerimiento->id}}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle del Pago</b></legend>
                            
                            <div class="form-group col-md-6">
                                <label for="pagoMonto" class="col-md-3 control-label" >Monto:</label>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="pagoMonto" autofocus maxlength="8"> 
                                </div>
                            </div>                           
                        </fieldset>  

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle de Expiracion</b></legend>

                            <div class="form-group col-md-6">
                                <label for="fechaExpiracion" class="col-md-3 control-label" >Fecha:</label>

                                <div class="col-md-9"> 
                                    <input type="date" class="form-control" name="expiracionFecha" autofocus min="<?php echo date("Y-m-d");?>"> 
                                </div>
                            </div>


                            <div class="form-group col-md-6">
                                <label for="horaExpiracion" class="col-md-3 control-label" >Hora:</label>

                                <div class="col-md-9">
                                    <input type="time" class="form-control" name="expiracionHora"> 
                                </div>
                            </div>                            
                        </fieldset>  

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar publicación
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
    <script src="{{ asset('/js/Publicacion/publicacion.js') }}"></script>
@endsection

