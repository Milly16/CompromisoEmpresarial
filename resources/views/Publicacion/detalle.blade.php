@extends('layouts.appA')
@section('content')
<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>DETALLE DEL PUBLICACION Nº {{ $publicacion->id }} </b></div>

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
                                        {{ $publicacion->requerimiento->iniciodireccion }}<br>
                                        {{ $publicacion->requerimiento->iniciod->descripcion }} - {{ $publicacion->requerimiento->iniciod->provincia->descripcion }} - {{ $publicacion->requerimiento->iniciod->provincia->departamento->descripcion }}
                                      </td>                 
                                    </tr>
                                    
                                    <tr>
                                      <td style="width: 30px;">
                                        <i class="fa fa-calendar-o" aria-hidden="true" style="color: #009688; font-size: 15px;"></i>
                                      </td> 

                                      <td>
                                        {{ \Carbon\Carbon::parse($publicacion->requerimiento->iniciofecha)->format('d-m-Y H:i')}}
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
                                        {{ $publicacion->requerimiento->finaldireccion }}<br>
                                        {{ $publicacion->requerimiento->finald->descripcion }} - {{ $publicacion->requerimiento->finald->provincia->descripcion }} - {{ $publicacion->requerimiento->finald->provincia->departamento->descripcion }}
                                      </td>                 
                                    </tr>
                                    
                                    <tr>
                                      <td style="width: 30px;">
                                        <i class="fa fa-calendar-o" aria-hidden="true" style="color: #E91E63; font-size: 15px;"></i>
                                      </td> 

                                      <td>
                                        {{ \Carbon\Carbon::parse($publicacion->requerimiento->finalfecha)->format('d-m-Y H:i')}}
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
                                            <td>{{ $publicacion->requerimiento->producto }}</td>
                                        </tr>
                                    
                                        <tr class="tr">
                                            <td><b>Peso: </b></td>
                                            <td>{{ $publicacion->requerimiento->pesoneto }} {{ $publicacion->requerimiento->pesounidad }} </td>
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
                                                {{ $publicacion->requerimiento->unidadcantidad }} 
                                                @if ($publicacion->requerimiento->unidadcantidad  > 1) unidades
                                                @else unidad
                                                @endif
                                            </td>
                                        </tr>
                                    
                                        <tr class="tr">
                                            <td><b>Tipo: </b></td>
                                            <td>{{ $publicacion->requerimiento->unidadtipo }}</td>
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
                                                @if ($publicacion->requerimiento->seguro  == 1) Si
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
                                            {{ $publicacion->requerimiento->pagometodo }} 
                                        </td>
                                    </tr>

                                    <tr class="tr">
                                        <td><b>Monto:</b></font></td>
                                        <td>
                                            @if ($publicacion->requerimiento->pagomoneda == 'sol') S/.
                                            @else $
                                            @endif
                                            {{ $publicacion->requerimiento->pagomonto }}
                                        </td>
                                    </tr>

                                    @if ($publicacion->requerimiento->pagometodo=="credito")
                                        <tr class="tr">
                                            <td><b>Dias:</b></font></td>
                                            <td>
                                            {{$publicacion->requerimiento->cantdias}}
                                            </td>
                                        </tr>   
                                    @endif      
                                                        
                                    <tr class="tr">
                                        <td><b>Incluye Igv: </b></td>
                                        <td>
                                            @if ($publicacion->requerimiento->igv  == 1) Si
                                            @else No
                                            @endif
                                        </td>
                                    </tr>

                                    <tr class="tr">
                                        <td><b>Pago por Tonelada: </b></td>
                                        <td>
                                            @if ($publicacion->requerimiento->portn  == 1) Si
                                            @else No
                                            @endif
                                        </td>
                                    </tr>

                                  </table>  
                                </div>

                                <div class="div-info">
                                    <section   style=" border-bottom: 1px dashed #CCC; margin-bottom: 6px;">
                                        <h5><b>Información del Publicacion.</b></h5>
                                    </section>
                                  
                                    <table>
                                        <tr class="tr">
                                        <td><b>Metodo Pago:</b></font></td>
                                        <td>
                                            contado
                                        </td>
                                    </tr>

                                    <tr class="tr">
                                        <td><b>Monto:</b></font></td>
                                        <td>
                                            S/.
                                            {{ $publicacion->pagomonto }}
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
@endsection

@section('scripts')
    
    <script src="{{ asset('/js/Publicacion/publicacion.js') }}"></script>
    <script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8TdjD2WKKq3DqFxJHERzSV9jwi5m-rEs&callback=initMap">
    </script>

    <script>
        var Disrecojo='{{ $publicacion->requerimiento->iniciod->descripcion }}'
        var Dirrecojo='{{ $publicacion->requerimiento->iniciodireccion }}'
        var Disenvio='{{ $publicacion->requerimiento->finald->descripcion }}'
        var Direnvio='{{ $publicacion->requerimiento->finaldireccion }}'

        recojo =  '"'+Dirrecojo +','+Disrecojo+'"';
        envio =  '"'+Direnvio +','+Disenvio+'"';

        console.log(envio);
        
        var map; 

    </script>
@endsection

