@extends('layouts.appA')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>


        <div class="col-md-12">
            <form class="form-horizontal" method="POST" id="form-reg-seleccion" action="{{ url('/seleccion/nuevo/').'/'.$id}}">
                {{ csrf_field() }}
                
                <div class="panel panel-default">
                    <div class="panel-heading" style="height: 50px;">
                        <b>LISTADO DE POSTULACIONES</b>
                        <div style="float: right;"><button class="btn btn-success">Registrar Seleccion</button></div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">          
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                        <th>Empresa</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($postulaciones as $postulacion)
                                    <tr data-toggle="collapse" data-tab="{{$postulacion->id}}" class="clickable collapse-row collapsed">
                                        <td> {{$postulacion->empresatran->empresa->razonsocial }} - {{$postulacion->empresatran->empresa->ruc }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding-bottom: 0px; padding-top: 0px">
                                            <div id="acordion{{$postulacion->id}}" class="collapse">
                                                <table class="table">
                                                    <thead>
                                                      <tr>
                                                        <th>Tipo</th>
                                                        <th>Modelo</th>
                                                        <th>Color</th>
                                                        <th>Año</th>
                                                        <th>Peso Bruto</th>
                                                        <th>Tracto</th>
                                                        <th>Carreta</th>
                                                        <th>Trabajador</th>
                                                        <th>Opcion</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody class="tbody">
                                                          
                                                    </tbody>
                                                </table>

                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="/js/Postulacion-Seleccion/seleccion.js"></script>
@endsection
