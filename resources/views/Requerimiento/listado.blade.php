@extends('layouts.appG')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE REQUERIMIENTOS</b></div>
                <div class="panel-body">
                	<b>Buscar:</b> <input class="form-control" id="buscar" type="text" placeholder="Buscar..">

                	<br>
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>Carga</th>
                                    <th>Recojer en...</th>
                                    <th>Entregar en...</th>
                                    <th>Unidades</th>
                                    <th>Pago</th>
                                    <th>Estado</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($requerimientos as $requerimiento)
                                <tr>
                                    <td>
                                        {{ $requerimiento->producto }} <br>
                                        {{ $requerimiento->pesoneto }} {{ $requerimiento->pesounidad }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($requerimiento->iniciofecha)->format('d-m-Y h:i')}}<br>
                                        {{ $requerimiento->iniciod->provincia->descripcion}} - {{ $requerimiento->iniciod->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($requerimiento->finalfecha)->format('d-m-Y')}}<br>
                                        {{ $requerimiento->finald->provincia->descripcion}} - {{ $requerimiento->finald->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ $requerimiento->unidadcantidad }} 
                                        @if ($requerimiento->unidadcantidad  > 1) unidades
                                        @else unidad
                                        @endif
                                        <br>
                                        {{ $requerimiento->unidadtipo }}
                                    </td>
                                    <td>
                                        {{ $requerimiento->pagometodo }} <br>
                                        @if ($requerimiento->pagomoneda == 'sol') S/.
                                        @else $
                                        @endif
                                        {{ $requerimiento->pagomonto }}
                                    </td>
                                    <td>
                                        {{ $requerimiento->estado }} <br>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ url('requerimiento/detalle/').'/'.$requerimiento->id }}"><i class="fa fa-eye"></i></a>
                                        @if ($requerimiento->estado == 'Nuevo')
                                            <a class="btn btn-sm btn-success" href="{{ url('requerimiento/editar/').'/'.$requerimiento->id }}"><i class="fa fa-edit"></i></a>
                                        @endif
                                        @if ($requerimiento->estado != 'Aceptado')
                                            <a class="btn btn-sm btn-danger"  data-delete="{{ $requerimiento->id }}"><i class="fa fa-times-circle"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $requerimientos->render() !!}
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
                <h4 class="modal-title"><b>Eliminar Requerimiento</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-del-requerimiento" action="{{ url('/requerimiento/delete') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de eliminar este requerimiento? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="delete-requerimiento">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 

@endsection


@section('scripts')
    <script src="{{ asset('/js/Requerimiento/requerimiento.js') }}"></script>
@endsection
