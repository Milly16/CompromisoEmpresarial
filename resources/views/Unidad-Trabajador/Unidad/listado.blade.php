@extends('layouts.appT')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-body">
                    <a class="btn btn-sm btn-info" href="nuevo"><i class="fa fa-pencil"></i> <b>NUEVO</b></a>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE UNIDADES</b></div>
                <div class="panel-body">
                	<b>Buscar:</b> <input class="form-control" id="buscar" type="text" placeholder="Buscar..">

                    <br>
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Modelo</th>
                                    <th>Color</th>
                                    <th>Año</th>
                                    <th>Peso Bruto</th>
                                    <th>Soat</th>
                                    <th>Placa Tracto</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($unidades as $key => $unidad)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>           
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
                                        {{ $unidad->pesobruto }} Tn
                                    </td>
                                    <td>
                                        Nº {{ $unidad->nsoat }} <br>
                                        Fecha: {{\Carbon\Carbon::parse($unidad->fechasoat)->format('d-m-Y')}}

                                    </td>   
                                    <td>
                                        {{ $unidad->placatracto }} 
                                    </td>
                                    
                                    <td>
                                        <a class="btn btn-sm btn-primary" href="{{ url('/unidad/visto/').'/'.$unidad->id }}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-success" href="{{ url('/unidad/editar/').'/'.$unidad->id }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger" data-delete="{{ $unidad->id }}"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                        {!! $unidades->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete-->
<div class="modal fade" id="modal-delete" role="dialog">
    <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><b>Eliminar Unidad</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-del-unidad" action="{{ url('/unidad/delete') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de eliminar esta unidad? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="delete-unidad">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection


@section('scripts')
    <script src="{{ asset('/js/Unidad-Trabajador/unidad.js') }}"></script>
@endsection

