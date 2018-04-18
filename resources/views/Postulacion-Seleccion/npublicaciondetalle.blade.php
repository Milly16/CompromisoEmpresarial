@extends('layouts.appT')
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
                            <b>DETALLE DEL PUBLICACION Nº {{ $npublicacion->id }} </b>
                        </div>
                        
                        
                        <div class="col-md-4" style="padding-left: 80px;">
                            <a  href="{{ url('/postulacion/nuevo').'/'.$npublicacion->id }}" class="btn btn-success" style="padding: 2px 8px;" > <i class="fa fa-check"></i> Aceptar</a>
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
                                        {{ $npublicacion->requerimiento->iniciodireccion }}<br>
                                        {{ $npublicacion->requerimiento->iniciod->descripcion }} - {{ $npublicacion->requerimiento->iniciod->provincia->descripcion }} - {{ $npublicacion->requerimiento->iniciod->provincia->departamento->descripcion }}
                                      </td>                 
                                    </tr>
                                    
                                    <tr>
                                      <td style="width: 30px;">
                                        <i class="fa fa-calendar-o" aria-hidden="true" style="color: #009688; font-size: 15px;"></i>
                                      </td> 

                                      <td>
                                        {{ \Carbon\Carbon::parse($npublicacion->requerimiento->iniciofecha)->format('d-m-Y H:i')}}
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
                                        {{ $npublicacion->requerimiento->finaldireccion }}<br>
                                        {{ $npublicacion->requerimiento->finald->descripcion }} - {{ $npublicacion->requerimiento->finald->provincia->descripcion }} - {{ $npublicacion->requerimiento->finald->provincia->departamento->descripcion }}
                                      </td>                 
                                    </tr>
                                    
                                    <tr>
                                      <td style="width: 30px;">
                                        <i class="fa fa-calendar-o" aria-hidden="true" style="color: #E91E63; font-size: 15px;"></i>
                                      </td> 

                                      <td>
                                        {{ \Carbon\Carbon::parse($npublicacion->requerimiento->finalfecha)->format('d-m-Y H:i')}}
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
                                            <td>{{ $npublicacion->requerimiento->producto }}</td>
                                        </tr>
                                    
                                        <tr class="tr">
                                            <td><b>Peso: </b></td>
                                            <td>{{ $npublicacion->requerimiento->pesoneto }} {{ $npublicacion->requerimiento->pesounidad }} </td>
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
                                                {{ $npublicacion->requerimiento->unidadcantidad }} 
                                                @if ($npublicacion->requerimiento->unidadcantidad  > 1) unidades
                                                @else unidad
                                                @endif
                                            </td>
                                        </tr>
                                    
                                        <tr class="tr">
                                            <td><b>Tipo: </b></td>
                                            <td>{{ $npublicacion->requerimiento->unidadtipo }}</td>
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
                                                @if ($npublicacion->requerimiento->seguro  == 1) Si
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
                                            contado
                                        </td>
                                    </tr>

                                    <tr class="tr">
                                        <td><b>Monto:</b></font></td>
                                        <td>
                                            S/.
                                            {{ $npublicacion->pagomonto }}
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
    <script src="/js/Postulacion-Seleccion/npublicacion.js"></script>

    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB8TdjD2WKKq3DqFxJHERzSV9jwi5m-rEs&callback=initMap">
    </script>
    
    <script>
        var Disrecojo='{{ $npublicacion->requerimiento->iniciod->descripcion }}'
        var Dirrecojo='{{ $npublicacion->requerimiento->iniciodireccion }}'
        var Disenvio='{{ $npublicacion->requerimiento->finald->descripcion }}'
        var Direnvio='{{ $npublicacion->requerimiento->finaldireccion }}'

        recojo =  '"'+Dirrecojo +','+Disrecojo+'"';
        envio =  '"'+Direnvio +','+Disenvio+'"';
        
        var map; 

    </script>
@endsection

