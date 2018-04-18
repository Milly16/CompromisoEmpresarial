@extends('layouts.appT')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>DETALLE DE POSTULACION</b></div>


                <div class="panel-body">
                    <fieldset  class="panel-details">
                        <legend  style="font-size: 15px;"><b>Informacion Publicacion Nº {{ $postulacion->publicacion->id }} </b></legend>
                            
                        <div class="form-group col-md-6">
                            <label for="tipo" class="col-md-3 control-label" >Carga:</label>

                            <div class="col-md-9">
                                {{ $postulacion->publicacion->requerimiento->producto }} 
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="marca" class="col-md-3 control-label" >Peso:</label>

                            <div class="col-md-9">
                                {{ $postulacion->publicacion->requerimiento->pesoneto }} {{ $postulacion->publicacion->requerimiento->pesounidad }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="modelo" class="col-md-3 control-label" >Recojo:</label>

                            <div class="col-md-9">
                                {{ $postulacion->publicacion->requerimiento->iniciod->provincia->descripcion }} - {{$postulacion->publicacion->requerimiento->iniciod->provincia->departamento->descripcion }} <br>
                                {{ \Carbon\Carbon::parse($postulacion->publicacion->requerimiento->iniciofecha)->format('d-m-Y G:i')}}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="color" class="col-md-3 control-label" >Entrega:</label>

                            <div class="col-md-9">
                                {{ $postulacion->publicacion->requerimiento->finald->provincia->descripcion }} - {{ $postulacion->publicacion->requerimiento->finald->provincia->departamento->descripcion }} <br>
                                {{ \Carbon\Carbon::parse($postulacion->publicacion->requerimiento->finalfecha)->format('d-m-Y')}}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="anio" class="col-md-3 control-label" >Pago:</label>

                            <div class="col-md-9">
                                 S/. {{ $postulacion->publicacion->pagomonto }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="anio" class="col-md-3 control-label" >Unidades:</label>

                            <div class="col-md-9">
                                 {{ $postulacion->publicacion->requerimiento->unidadcantidad }} 
                                                @if ($postulacion->publicacion->requerimiento->unidadcantidad  > 1) unidades
                                                @else unidad
                                                @endif
                                - {{ $postulacion->publicacion->requerimiento->unidadtipo }}
                            </div>
                        </div>
                    </fieldset>

                    <form class="form-horizontal" method="POST" id="form-reg-postulacion" action="{{ url('/postulacion/nuevo/').'/'.$postulacion->publicacion->id}}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle del Postulación</b></legend>
                            
                            <div class="table-responsive">                        
                                <table id="tablaUnidad" class="table table-bordered tabla">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tipo</th>
                                            <th>Modelo</th>
                                            <th>Color</th>
                                            <th>Año</th>
                                            <th>Peso Bruto</th>
                                            <th>Tracto</th>
                                            <th>Carreta</th>
                                            <th>Trabajador</th>
                                            </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach($detallesPostulacion as $key => $detallePostulacion)
                                        <tr>
                                            <td>
                                                {{$key+1}} 
                                            </td>  
                                            <td>
                                                {{ $detallePostulacion->unidad->tipo }}
                                            </td>
                                            <td>
                                                {{ $detallePostulacion->unidad->modelo }}
                                            </td>
                                            <td>
                                                {{ $detallePostulacion->unidad->color }}
                                            </td>
                                            <td>
                                                {{ $detallePostulacion->unidad->anio }}
                                            </td>
                                            <td>
                                                {{ $detallePostulacion->unidad->pesobruto }}
                                            </td>
                                            <td>
                                                MTC: {{ $detallePostulacion->unidad->mtctracto }} <br>
                                                Placa: {{ $detallePostulacion->unidad->placatracto }}
                                            </td>
                                            <td>
                                                MTC: {{ $detallePostulacion->unidad->mtccarreta }} <br>
                                                Placa: {{ $detallePostulacion->unidad->placacarreta }}
                                            </td>
                                            <td>
                                                {{ $detallePostulacion->trabajador->nombre }} {{ $detallePostulacion->trabajador->apellido }}
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    
                                </table> 
                            </div>                         
                        </fieldset>  

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')
    <script src="/js/Postulacion-Seleccion/postulacion.js"></script>
@endsection

