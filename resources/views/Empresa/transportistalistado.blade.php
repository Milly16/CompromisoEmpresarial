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
                <div class="panel-heading"><b>LISTADO DE TRANSPORTISTAS</b></div>
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
                                    <th>Archivo</th>
                                    <th>Direccion</th>
                                    <th>Opciones</th>
                              </tr>
                            </thead>
                            <tbody id="tabla">
                                @foreach($transportistas as $key => $transportista)
                                <tr>
                                    <td>
                                        {{$key+1}} 
                                    </td>           
                                    <td>
                                        {{ $transportista->empresa->ruc }}
                                    </td>
                                    <td>
                                        {{ $transportista->empresa->razonsocial }}
                                    </td>
                                    <td>
                                        {{ $transportista->empresa->contnombre }} {{ $transportista->empresa->contapellido }} <br>
                                        {{ $transportista->empresa->conttelefono }}
                                    </td>
                                
                                    <td>
                                        {{ $transportista->empresa->direccion }} <br>
                                        {{ $transportista->empresa->distrito->descripcion }}
                                    </td>
                                    <td>
                                        <a class="btn btn-sm btn-success" href="{{ url('/transportista/editar').'/'.$transportista->empresa_id }}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-sm btn-danger" data-delete="{{ $transportista->empresa->id }}"><i class="fa fa-times-circle"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            
                        </table>
                        {!! $transportistas->render() !!}
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
                <form role="form" id="form-del-transportista" action="{{ url('/transportista/eliminar') }}">
                {{ csrf_field() }}
                    <input hidden name="id">
                    <div class="row">
                        <p>¿Está seguro de eliminar esta Empresa Transportista? </p>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                <a href="#" class="btn btn-success" id="delete-transportista">Eliminar</a>
            </div>
        </div>
      
    </div>
</div> 
@endsection


@section('scripts')
    <script src="/js/Empresa/transportista.js"></script>
@endsection

