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

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE TRABAJORES</b></div>
                <div class="panel-body">
                	<b>Buscar:</b> <input class="form-control" id="buscar" type="text" placeholder="Buscar..">

                    <br>
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>#</th>
                                    <th>Dni</th>
                                    <th>Nombre Completo</th>
                                    <th>Celular</th>
                                    <th>Brevete</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($trabajadores as $key => $trabajador)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>           
                                    <td>
                                        {{ $trabajador->dni }}
                                    </td>
                                    <td>
                                        {{ $trabajador->nombre }} {{ $trabajador->apellido }}
                                    </td>
                                    <td>
                                        {{ $trabajador->celular }}
                                    </td>
                                    <td>
                                        {{ $trabajador->brevete }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-primary" data-view="{{ $trabajador->id }}" data-nro="{{$key+1}}"><i class="fa fa-eye"></i></a>
                                        <a class="btn btn-sm btn-success" href="{{ url('/trabajador/editar/').'/'.$trabajador->id }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger" data-delete="{{ $trabajador->id }}"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $trabajadores->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="modal-details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-title" style="display: flex;">Detalle del trabajador Nro <div class="nro"></div></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">          
                    <table class="table table-details">
                        <tbody>
                            <tr>
                                <td>DNI</td>
                                <td id="dni"></td>
                            </tr>
                            <tr>
                                <td>Nombres</td>
                                <td id="nombre"></td>
                            </tr>
                            <tr>
                                <td>Apellidos</td>
                                <td id="apellido"></td>
                            </tr>
                            <tr>
                                <td>Celular</td>
                                <td id="celular"></td>
                            </tr>
                            <tr>
                                <td>Direccion</td>
                                <td id="direccion"></td>
                            </tr>
                            <tr>
                                <td>Fecha de Nacimiento</td>
                                <td id="fechNacimiento"></td>
                            </tr>
                            <tr>
                                <td>Brevete</td>
                                <td id="brevete"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title"><b>Eliminar Trabajador</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-del-trabajador" action="{{ url('/trabajador/delete') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de eliminar éste trabajador? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="delete-trabajador">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection


@section('scripts')
    <script src="{{ asset('/js/Unidad-Trabajador/trabajador.js') }}"></script>
@endsection

