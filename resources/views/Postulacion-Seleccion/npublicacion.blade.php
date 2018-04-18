@extends('layouts.appT')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE NUEVAS PUBLICACIONES</b></div>
                <div class="panel-body">
                    <b>Buscar:</b> <input class="form-control" id="buscar" type="text" placeholder="Buscar..">
                    <br>
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>#</th>
                                    <th>Carga</th>
                                    <th>Recojer en...</th>
                                    <th>Entregar en...</th>
                                    <th>Unidades</th>
                                    <th>Pago</th>
                                    <th>Fecha Maxima</th>
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
                                        S/.{{ $publicacion->pagomonto }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($publicacion->fechaexpiracion)->format('d-m-Y G:i')}}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ url('/npublicacion/detalle').'/'.$publicacion->id }}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-success" href="{{ url('/postulacion/nuevo').'/'.$publicacion->id }}"><i class="fa fa-check-square-o"></i></a>
                                        <a class="btn btn-sm btn-danger"  data-rechazar="{{ $publicacion->id }}"><i class="fa fa-times-circle"></i></a>
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
<div class="modal fade" id="modal-rechazar" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Rechazar Publicación</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-rech-publicacion" action="{{ url('/npublicacion/rechazar') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de rechazar esta publicacion? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="rechazar-publicacion">Rechazar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection

@section('scripts')
    <script src="/js/Postulacion-Seleccion/npublicacion.js"></script>
@endsection


