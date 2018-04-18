@extends('layouts.appA')

@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-8">
                            <b>DETALLE DEL REQUERIMIENTO Nº {{ $nrequerimiento->id }} </b>
                        </div>
                    
                    
                        <div class="col-md-4" style="padding-left: 80px;">
                            <a  href="{{ url('/publicacion/nuevo').'/'.$nrequerimiento->id }}" class="btn btn-success" style="padding: 2px 8px;" > <i class="fa fa-check"></i> Aceptar</a>
                            <a  id="rechazar" class="btn btn-danger" style="padding: 2px 8px;" <i class="fa fa-times-circle"></i> Rechazar </a>
                        </div> 
                    </div> 
                </div>

                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-7">
                            <div>
                                <div class="portlet-content">
                                    <h4 class="heading"><b>Informaci&oacute;n de la Origen y Destino.</b></h4>
                                    <div class="col-sm-12">
                                        <div id="map"></div>

                                        <div style="border: 1px dashed #ff0808">
                                            <b>Distancia:</b> {{ $distancia }}
                                            <b>Tiempo:</b> {{ $tiempo }}
                                            <b>Galon:</b> {{ $galon }} aprox.
                                        </div>

                                    </div>
                                </div> <!-- /.portlet-content -->
                            </div>

                            <div class="col-sm-12">
                                <div class="col-sm-6">
                                  <section   style=" border-bottom: 1px dashed #CCC; margin-bottom: 6px;">
                                    <h5><b>Información de Recojo de Carga.</b></h5>
                                  </section>

                                  <table>
                                    <tr>
                                      <td style="padding-bottom: 16px; width: 30px;">
                                        <i class="fa fa-map-marker" aria-hidden="true" style="color: #009688; font-size: 18px;"></i>                    
                                      </td> 

                                      <td style="padding-bottom: 7px;">
                                        {{ $nrequerimiento->iniciodireccion }}<br>
                                        {{ $nrequerimiento->iniciod->descripcion }} - {{ $nrequerimiento->iniciod->provincia->descripcion }} - {{ $nrequerimiento->iniciod->provincia->departamento->descripcion }}
                                      </td>                 
                                    </tr>
                                    
                                    <tr>
                                      <td style="width: 30px;">
                                        <i class="fa fa-calendar-o" aria-hidden="true" style="color: #009688; font-size: 15px;"></i>
                                      </td> 

                                      <td>
                                        {{ \Carbon\Carbon::parse($nrequerimiento->iniciofecha)->format('d-m-Y H:i')}}
                                      </td>                 
                                    </tr>
                        
                                  </table>
                                </div>

                                <div class="col-sm-6">
                                  <section   style=" border-bottom: 1px dashed #CCC; margin-bottom: 6px;">
                                    <h5><b>Información de Entrega de Carga.</b></h5>
                                  </section>

                                  <table>
                                    <tr>
                                      <td style="padding-bottom: 16px; width: 30px;">
                                        <i class="fa fa-map-marker" aria-hidden="true" style="color: #E91E63; font-size: 18px;"></i>                    
                                      </td> 

                                      <td style="padding-bottom: 7px;">
                                        {{ $nrequerimiento->finaldireccion }}<br>
                                        {{ $nrequerimiento->finald->descripcion }} - {{ $nrequerimiento->finald->provincia->descripcion }} - {{ $nrequerimiento->finald->provincia->departamento->descripcion }}
                                      </td>                 
                                    </tr>
                                    
                                    <tr>
                                      <td style="width: 30px;">
                                        <i class="fa fa-calendar-o" aria-hidden="true" style="color: #E91E63; font-size: 15px;"></i>
                                      </td> 

                                      <td>
                                        {{ \Carbon\Carbon::parse($nrequerimiento->finalfecha)->format('d-m-Y H:i')}}
                                      </td>                 
                                    </tr>
                        
                                  </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="portlet-content">
                                <div class="div-info">
                                    <section   style=" border-bottom: 1px dashed #CCC; margin-bottom: 6px;">
                                        <h5><b>Información del Producto.</b></h5>
                                    </section>
                                  
                                    <table>
                                        <tr class="tr">
                                            <td><b>Descripción:</b></font></td>
                                            <td>{{ $nrequerimiento->producto }}</td>
                                        </tr>
                                    
                                        <tr class="tr">
                                            <td><b>Peso: </b></td>
                                            <td>{{ $nrequerimiento->pesoneto }} {{ $nrequerimiento->pesounidad }} </td>
                                        </tr>
                                    </table>
                                </div>

                                <div class="div-info">
                                    <section   style=" border-bottom: 1px dashed #CCC; margin-bottom: 6px;">
                                        <h5><b>Información del Unidades.</b></h5>
                                    </section>
                                  
                                    <table>
                                        <tr class="tr">
                                            <td><b>Cantidad:</b></font></td>
                                            <td>
                                                {{ $nrequerimiento->unidadcantidad }} 
                                                @if ($nrequerimiento->unidadcantidad  > 1) unidades
                                                @else unidad
                                                @endif
                                            </td>
                                        </tr>
                                    
                                        <tr class="tr">
                                            <td><b>Tipo: </b></td>
                                            <td>{{ $nrequerimiento->unidadtipo }}</td>
                                        </tr>

                                        <tr class="tr">
                                            <td style="padding-bottom: 38px;"><b>Requisitos: </b></td>
                                            <td>
                                                <ul class="description">
                                                    @foreach ($lineas as $linea)
                                                    <li>{{$linea}}</li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                        </tr>

                                        <tr class="tr">
                                            <td><b>Incluye Seguro <br> de carga: </b></td>
                                            <td>
                                                @if ($nrequerimiento->seguro  == 1) Si
                                                @else No
                                                @endif
                                            </td>
                                        </tr>
                                    </table>  
                                </div> 

                                <div class="div-info">
                                    <section   style=" border-bottom: 1px dashed #CCC; margin-bottom: 6px;">
                                        <h5><b>Información del Pago.</b></h5>
                                    </section>
                                  
                                    <table>
                                        <tr class="tr">
                                        <td><b>Metodo Pago:</b></font></td>
                                        <td>
                                            {{ $nrequerimiento->pagometodo }} 
                                        </td>
                                    </tr>

                                    <tr class="tr">
                                        <td><b>Monto:</b></font></td>
                                        <td>
                                            {{ $nrequerimiento->pagometodo }} <br>
                                            @if ($nrequerimiento->pagomoneda == 'sol') S/.
                                            @else $
                                            @endif
                                            {{ $nrequerimiento->pagomonto }}
                                        </td>
                                    </tr>

                                    @if ($nrequerimiento->pagometodo=="credito")
                                        <tr class="tr">
                                            <td><b>Dias:</b></font></td>
                                            <td>
                                            {{$nrequerimiento->cantdias}}
                                            </td>
                                        </tr>   
                                    @endif      
                                                        
                                    <tr class="tr">
                                        <td><b>Incluye Igv: </b></td>
                                        <td>
                                            @if ($nrequerimiento->igv  == 1) Si
                                            @else No
                                            @endif
                                        </td>
                                    </tr>

                                    <tr class="tr">
                                        <td><b>Pago por Tonelada: </b></td>
                                        <td>
                                            @if ($nrequerimiento->portn  == 1) Si
                                            @else No
                                            @endif
                                        </td>
                                    </tr>

                                  </table>  
                                </div>
                            </div>
                        </div>

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
                    <input hidden name="id" value="{{ $nrequerimiento->id }}">
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

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8TdjD2WKKq3DqFxJHERzSV9jwi5m-rEs&callback=initMap">
    </script>
    
    <script>
        var Disrecojo='{{ $nrequerimiento->iniciod->descripcion }}'
        var Dirrecojo='{{ $nrequerimiento->iniciodireccion }}'
        var Disenvio='{{ $nrequerimiento->finald->descripcion }}'
        var Direnvio='{{ $nrequerimiento->finaldireccion }}'

        recojo =  '"'+Dirrecojo +','+Disrecojo+'"';
        envio =  '"'+Direnvio +','+Disenvio+'"';
        
        var map; 

    </script>
@endsection

