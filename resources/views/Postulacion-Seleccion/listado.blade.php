@extends('layouts.appT')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE PUBLICACIONES QUE HA POSTULADO</b></div>
                <div class="panel-body">
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>#</th>
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
                            <tbody>
                                @foreach($postulaciones as $key => $postulacion)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>  
                                    <td>
                                        {{ $postulacion->publicacion->requerimiento->producto }} <br>
                                        {{ $postulacion->publicacion->requerimiento->pesoneto }} {{ $postulacion->publicacion->requerimiento->pesounidad }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($postulacion->publicacion->requerimiento->iniciofecha)->format('d-m-Y G:i')}}<br>
                                        {{ $postulacion->publicacion->requerimiento->iniciod->provincia->descripcion}} - {{ $postulacion->publicacion->requerimiento->iniciod->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($postulacion->publicacion->requerimiento->finalfecha)->format('d-m-Y')}}<br>
                                        {{ $postulacion->publicacion->requerimiento->finald->provincia->descripcion}} - {{ $postulacion->publicacion->requerimiento->finald->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ $postulacion->publicacion->requerimiento->unidadcantidad }} 
                                        @if ($postulacion->publicacion->requerimiento->unidadcantidad  > 1) unidades
                                        @else unidad
                                        @endif
                                        <br>
                                        {{ $postulacion->publicacion->requerimiento->unidadtipo }}
                                    </td>
                                    <td>
                                        S/.{{ $postulacion->publicacion->pagomonto }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($postulacion->publicacion->fechaexpiracion)->format('d-m-Y G:i')}}
                                    </td>
                                    <td>
                                        {{ $postulacion->publicacion->estado }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ url('/postulacion/detalle').'/'.$postulacion->id }}"><i class="fa fa-eye"></i></a>
                                        @if ($postulacion->publicacion->estado != 'Cerrado')
                                        <a class="btn btn-sm btn-success" href="{{ url('/postulacion/editar').'/'.$postulacion->id }}"><i class="fa fa-edit"></i></a>
                                        @endif
                                        <a class="btn btn-sm btn-danger"  data-delete="{{ $postulacion->id }}"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                  
                        </table>
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal-delete" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Eliminar postulacion</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-del-postulacion" action="{{ url('/postulacion/eliminar') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de desea eliminar postulacion? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="eliminar-postulacion">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection

@section('scripts')
    <script src="{{ asset('/js/Postulacion-Seleccion/postulacion.js') }}"></script>
@endsection


