@extends('layouts.appA')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <!-- <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-warning">
                <div class="panel-body">
                    <a class="btn btn-sm btn-info" href="nuevo"><i class="fa fa-pencil"></i> <b>NUEVO</b></a>
                </div>
            </div>
        </div> -->

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>LISTADO DE GENERADORES DE CARGA</b></div>
                <div class="panel-body">
                	<b>Buscar:</b> <input class="form-control" id="buscar" type="text" placeholder="Buscar..">
                	<br>
                    <div class="table-responsive">          
                        <table class="table table-bordered">
                            <thead>
                              <tr>
                                    <th>#</th>
                                    <th>Ruc</th>
                                    <th>Razon Social</th>
                                    <th>Contacto</th>
                                    <th>Encargado</th>
                                    <th>Direccion</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($generadores as $key => $generador)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>           
                                    <td>
                                        {{ $generador->empresa->ruc }}
                                    </td>
                                    <td>
                                        {{ $generador->empresa->razonsocial }}
                                    </td>
                                    <td>
                                        {{ $generador->empresa->contnombre }} {{ $generador->empresa->contapellido }} <br>
                                        {{ $generador->empresa->conttelefono }}
                                    </td>
                                    <td>
                                        {{ $generador->empresa->empresa_gen->encargnombre }} {{ $generador->empresa->empresa_gen->encargapellido }} <br>
                                        {{ $generador->empresa->empresa_gen->encargtelefono }}
                                    </td>
                                    <td>
                                        {{ $generador->empresa->direccion }} <br>
                                        {{ $generador->empresa->distrito->descripcion }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-success" href="{{ url('/generador/editar').'/'.$generador->empresa_id }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger" data-delete="{{ $generador->empresa_id }}"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                        {!! $generadores->render() !!}
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
                <h4 class="modal-title"><b>Eliminar Generador de Carga</b></h4>
            </div>
            <div class="modal-body" style="padding:8px 50px;">
                <form role="form" id="form-del-generador" action="{{ url('/generador/eliminar') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de eliminar esta Empresa Generadora de Carga? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="delete-generador">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection


@section('scripts')
    <script src="/js/Empresa/generador.js"></script>
@endsection

