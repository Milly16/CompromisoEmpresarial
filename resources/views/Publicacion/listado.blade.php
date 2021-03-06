@extends('layouts.appA')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE PUBLICACIONES</b></div>
                <div class="panel-body">
                	<b>Buscar:</b> <input class="form-control" id="buscar" type="text" placeholder="Buscar..">
                    <br>
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>#</th>
                                    <th>Empresa</th>
                                    <th>Carga</th>
                                    <th>Recojer en...</th>
                                    <th>Entregar en...</th>
                                    <th>Unidades</th>
                                    <th>Pago-Req</th>
                                    <th>Pago-Publ</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($publicaciones as $key => $publicacion)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>  
                                    <td>
                                        {{ $publicacion->requerimiento->empresa->razonsocial }} <br>
                                        RUC: {{ $publicacion->requerimiento->empresa->ruc }}
                                    </td>
                                    <td>
                                        {{ $publicacion->requerimiento->producto }} <br>
                                        {{ $publicacion->requerimiento->pesoneto }} {{ $publicacion->requerimiento->pesounidad }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($publicacion->requerimiento->iniciofecha)->format('d-m-Y G:i')}}<br>
                                        {{ $publicacion->requerimiento->iniciod->provincia->descripcion}} - {{ $publicacion->requerimiento->iniciod->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($publicacion->requerimiento->finalfecha)->format('d-m-Y')}}<br>
                                        {{ $publicacion->requerimiento->finald->provincia->descripcion}} - {{ $publicacion->requerimiento->finald->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ $publicacion->requerimiento->unidadcantidad }} 
                                        @if ($publicacion->requerimiento->unidadcantidad  > 1) unidades
                                        @else unidad
                                        @endif
                                        <br>
                                        {{ $publicacion->requerimiento->unidadtipo }}
                                    </td>
                                    <td>
                                        {{ $publicacion->requerimiento->pagometodo }} <br>
                                        @if ($publicacion->requerimiento->pagomoneda == 'sol') S/.
                                        @else $
                                        @endif
                                        {{ $publicacion->requerimiento->pagomonto }}
                                    </td>
                                    <td>
                                        S/.{{ $publicacion->pagomonto }}
                                    </td>
                                    <td>
                                        {{ $publicacion->estado }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ url('/publicacion/detalle').'/'.$publicacion->id }}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-success" href="{{ url('/publicacion/editar').'/'.$publicacion->id }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger"  data-eliminar="{{ $publicacion->id }}"><i class="fa fa-times-circle"></i></a>
                                        @if ($publicacion->estado == 'Cerrado')
                                            <a class="btn btn-sm btn-warning"  data-sel-detalle="{{ $publicacion->id }}"><i class="fa fa-list-alt"></i></a>
                                            <a class="btn btn-sm btn-info" href="{{ url('excel/reporte/' . $publicacion->id) }}" ><i class="fa fa-file-excel-o"></i></a>
                                        @endif
                                        
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $publicaciones->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-eliminar" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Eliminar Publicacion</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-del-publicacion" action="{{ url('/publicacion/eliminar') }}">
                {{ csrf_field() }}
                    <input  name="id">
                    <div class="row">
                        <p>¿Está seguro de eliminar esta publicacion? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="eliminar-publicacion">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 

<!-- Modal -->
<div class="modal fade" id="modal-rechazar" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Rechazar Requerimiento</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-rech-requerimiento" action="{{ url('/nrequerimiento/rechazar') }}">
                {{ csrf_field() }}
                    <input name="id">
                    <div class="row">
                        <p>¿Está seguro de rechazar este requerimiento? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-danger" id="cancelar-peticion">Cancelar</a>
                <a href="#" class="btn btn-success" id="rechazar-requerimiento">Rechazar</a>
            </div>
        </div>
      
    </div>
</div> 

<div class="modal fade" id="modal-sel-detalle" role="dialog">
    <div class="modal-dialog modal-lg">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Detalle de la selección</b></h4>
            </div>

            <div class="modal-body">
                <div class="table-responsive">          
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Empresa</th>
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
                        <tbody class="tbody">
                                                              
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      
    </div>
</div> 
@endsection

@section('scripts')
    <script src="{{ asset('/js/Publicacion/publicacion.js') }}"></script>
@endsection


