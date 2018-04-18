@extends('layouts.appA')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE NUEVOS REQUERIMIENTOS</b></div>
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
                                    <th>Pago</th>
                                    <th>Maxima Fecha</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($nrequerimientos as $key => $nrequerimiento)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>  
                                    <td>
                                        {{ $nrequerimiento->empresagen->empresa->razonsocial }} <br>
                                        RUC: {{ $nrequerimiento->empresagen->empresa->ruc }}
                                    </td>
                                    <td>
                                        {{ $nrequerimiento->producto }} <br>
                                        {{ $nrequerimiento->pesoneto }} {{ $nrequerimiento->pesounidad }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($nrequerimiento->iniciofecha)->format('d-m-Y G:i')}}<br>
                                        {{ $nrequerimiento->iniciod->provincia->descripcion}} - {{ $nrequerimiento->iniciod->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($nrequerimiento->finalfecha)->format('d-m-Y')}}<br>
                                        {{ $nrequerimiento->finald->provincia->descripcion}} - {{ $nrequerimiento->finald->provincia->departamento->descripcion}}
                                    </td>
                                    <td>
                                        {{ $nrequerimiento->unidadcantidad }} 
                                        @if ($nrequerimiento->unidadcantidad  > 1) unidades
                                        @else unidad
                                        @endif
                                        <br>
                                        {{ $nrequerimiento->unidadtipo }}
                                    </td>
                                    <td>
                                        {{ $nrequerimiento->pagometodo }} <br>
                                        @if ($nrequerimiento->pagomoneda == 'sol') S/.
                                        @else $
                                        @endif
                                        {{ $nrequerimiento->pagomonto }}
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($nrequerimiento->maximafecha)->format('d-m-Y G:i')}} <br>
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ url('/nrequerimiento/detalle').'/'.$nrequerimiento->id }}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-success" href="{{ url('/publicacion/nuevo').'/'.$nrequerimiento->id }}"><i class="fa fa-check-square-o"></i></a>
                                        <a class="btn btn-sm btn-danger"  data-rechazar="{{ $nrequerimiento->id }}"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $nrequerimientos->render() !!}
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
                <h4 class="modal-title"><b>Rechazar Requerimiento</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-rech-requerimiento" action="{{ url('/nrequerimiento/rechazar') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de rechazar este requerimiento? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="rechazar-requerimiento">Rechazar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection

@section('scripts')
    <script src="{{ asset('/js/Publicacion/publicacion.js') }}"></script>
@endsection


