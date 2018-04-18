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
                            <tbody>
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
                                        <a class="btn btn-sm btn-primary" href="{{ url('/postulaciones').'/'.$publicacion->id }}"><i class="fa fa-eye"></i></a>
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
@endsection

@section('scripts')
    <script src="/js/Publicacion/publicacion.js"></script>
@endsection


