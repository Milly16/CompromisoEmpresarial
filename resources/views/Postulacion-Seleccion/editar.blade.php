@extends('layouts.appT')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>EIDTAR DE POSTULACION</b></div>


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

                    <form class="form-horizontal" method="POST" id="form-edit-postulacion" action="{{ url('/postulacion/editar/').'/'.$postulacion->id}}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle del Postulación</b></legend>

                            <div style="margin-bottom: 1em;">
                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Units">Agregar Unidades</button>
                            </div>
                            
                            <div class="table-responsive">                        
                                <table id="tablaUnidad" class="table table-bordered tabla">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Modelo</th>
                                            <th>Color</th>
                                            <th>Año</th>
                                            <th>Peso Bruto</th>
                                            <th>Tracto</th>
                                            <th>Carreta</th>
                                            <th>Trabajador</th>
                                            <th>Opciones</th>
                                        </tr>
                                    </thead>
                                  
                                    <tbody>
                                        @foreach($detallesPostulacion as $key => $detallePostulacion)
                                        <tr>
                                            <td style="display:none"><input type="text" name="idUnit[]" value="{{ $detallePostulacion->unidad->id }}"></td> 
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
                                            <td name="td">
                                                <select name="idWorked[]" id="trabajador">
                                                    <option value="0">Seleccionar Trabajador</option>
                                                    @foreach($trabajadores as $key => $trabajador)
                                                    <option value="{{$trabajador->id}}" @if ($trabajador->id == old('trabajador', $detallePostulacion->trabajador->id ))
                                                        selected="selected" @endif>{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger" data-eliminar>Eliminar</button>
                                            </td>
                                            
                                        </tr>
                                        @endforeach

                                    </tbody>
                                    
                                </table> 
                            </div>                         
                        </fieldset>  

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Editar postulación
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="Units" role="dialog">
    <div class="modal-dialog modal-lg">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Selecciona Unidades...</h4>
            </div>
            
            <div class="modal-body">
                <div class="table-responsive"> 
                    <table class="table table-bordered" id="tablaSeleccion">
                        <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Año</th>
                                <th>Peso Bruto</th>
                                <th>Tracto</th>
                                <th>Carreta</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($unidades as $unidad)
                            <tr>         
                                <td style="display:none"><input type="text" name="idUnit[]" value="{{ $unidad->id }}"></td> 
                                <td>
                                    {{ $unidad->tipo }}
                                </td>
                                <td>
                                    {{ $unidad->modelo }}
                                </td>
                                <td>
                                    {{ $unidad->color }}
                                </td>
                                <td>
                                    {{ $unidad->anio }}
                                </td>
                                <td>
                                    {{ $unidad->pesobruto }}
                                </td>
                                <td>
                                    MTC: {{ $unidad->mtctracto }} <br>
                                    Placa: {{ $unidad->placatracto }}
                                </td>
                                <td>
                                    MTC: {{ $unidad->mtccarreta }} <br>
                                    Placa: {{ $unidad->placacarreta }}
                                </td>
                                <td name="td" style="display:none;">
                                    <select name="idWorked[]" id="trabajador">
                                        <option value="0">Seleccionar Trabajador</option>
                                        @foreach($trabajadores as $key => $trabajador)
                                        <option value="{{ $trabajador->id }}">{{ $trabajador->nombre }} {{ $trabajador->apellido }}</option>
                                        @endforeach
                                    </select>

                                </td>
                                        
                                <td>
                                    <button type="button" class="btn btn-success" data-seleccionar>Seleccionar</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>              
                    </table>
                    {!! $unidades->render() !!}
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
      
    </div>
</div>


@endsection


@section('scripts')
    <script src="{{ asset('/js/Postulacion-Seleccion/postulacion.js') }}"></script>
@endsection

