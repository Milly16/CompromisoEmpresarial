@extends('layouts.appA')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>EDITAR PUBLICACION</b></div>


                <div class="panel-body">

                    <form class="form-horizontal" method="POST" id="form-edit-publicacion" 
                        @if($publicacion->estado == "Nuevo") action="{{ url('/publicacion/editar').'/'.$publicacion->id }}"
                        @else action="{{ url('/publicacion/modificada/editar').'/'.$publicacion->id }}"
                        @endif
                        

                    >
                        {{ csrf_field() }}
                        
                            @if($publicacion->estado == "Nuevo")
                            <fieldset>
                                <legend  style="font-size: 15px;"><b>Detalle de la carga</b></legend>
                                    
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="producto" class="col-md-3 control-label" >Producto:</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="producto" autofocus value="{{ $publicacion->requerimiento->producto }}"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-offset-1">
                                    <div class="form-group col-md-6">
                                        <label for="pesoNeto" class="col-md-4 control-label" >Peso Neto:</label>

                                        <div class="col-md-8 input-move">
                                            <input type="text" class="form-control" name="pesoNeto" autofocus value="{{ $publicacion->requerimiento->pesoneto }}"> 
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="pesoUnidad" class="col-md-4 control-label" >Unidad:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" name="pesoUnidad">                                        
                                                <option value="Tn" @if( old('pesounidad', $publicacion->requerimiento->pesounidad) == 'Tn') selected="selected" @endif>Toneladas</option>
                                                <option value="Kg" @if( old('pesounidad', $publicacion->requerimiento->pesounidad) == 'Kg') selected="selected" @endif>Kilogramo</option>
                                                <option value="Lb" @if( old('pesounidad', $publicacion->requerimiento->pesounidad) == 'Lb') selected="selected" @endif>Libras</option>
                                                <option value="Lt" @if( old('pesounidad', $publicacion->requerimiento->pesounidad) == 'Lt') selected="selected" @endif>Litros</option>
                                                <option value="M3" @if( old('pesounidad', $publicacion->requerimiento->pesounidad) == 'M3') selected="selected" @endif>Metros Cubicos</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            @endif

                            <fieldset>
                                <legend  style="font-size: 15px;"><b>Recojer la carga ...</b></legend>
                                @if($publicacion->estado == "Nuevo")
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="departamento" class="col-md-3 control-label" >Departamento:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" id="select-departamento-inicio">
                                                <option value="">Seleccione departamento</option>
                                                @foreach ($departamentos as $departamento)
                                                <option value="{{$departamento->id}}" @if ($departamento->id == old('select-departamento-inicio', $publicacion->requerimiento->iniciod->provincia->departamento_id ))
                                                    selected="selected" @endif>{{$departamento->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="provincia" class="col-md-3 control-label" >Provincia:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" id="select-provincia-inicio">
                                                <option value="">Seleccione provincia</option>
                                                @foreach ($i_provincias as $i_provincia)
                                                <option value="{{$i_provincia->id}}" @if ($i_provincia->id == old('select-provincia-inicio', $publicacion->requerimiento->iniciod->provincia_id )) 
                                                        selected="selected" @endif>{{$i_provincia->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="distrito" class="col-md-3 control-label" >distrito:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" name="iniciodistrito" id="select-distrito-inicio">
                                                <option value="">Seleccione distrito</option>
                                                @foreach ($i_distritos as $i_distrito)
                                                <option value="{{$i_distrito->id}}" @if ($i_distrito->id == old('select-distrito-inicio', $publicacion->requerimiento->iniciod_id )) 
                                                        selected="selected" @endif>{{$i_distrito->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <label for="inicioDireccion" class="col-md-3 control-label" >Direccion:</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="inicioDireccion" autofocus value="{{ $publicacion->requerimiento->iniciodireccion }}"> 
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-sm-offset-1">                        
                                    <div class="form-group col-md-6">
                                        <label for="inicioFecha" class="col-md-4 control-label" >Fecha:</label>

                                        <div class="col-md-8 input-move"> 
                                            <input type="date" class="form-control" name="inicioFecha" autofocus min="<?php echo date("Y-m-d");?>" value="{{ \Carbon\Carbon::parse($publicacion->requerimiento->iniciofecha)->format('Y-m-d')}}">
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="inicioHora" class="col-md-4 control-label" >Hora:</label>

                                        <div class="col-md-8">
                                            <input type="time" class="form-control" name="inicioHora" value="{{ \Carbon\Carbon::parse($publicacion->requerimiento->iniciofecha)->format('H:i')}}"> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        

                            <fieldset>
                                <legend  style="font-size: 15px;"><b>Entregar la carga ...</b></legend>
                                <div class="col-md-12">
                                    @if($publicacion->estado == "Nuevo")
                                    <div class="form-group">
                                        <label for="departamento" class="col-md-3 control-label" >Departamento:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" id="select-departamento-final">
                                                <option value="">Seleccione departamento</option>
                                                @foreach ($departamentos as $departamento)
                                                <option value="{{$departamento->id}}" @if ($departamento->id == old('select-departamento-final', $publicacion->requerimiento->finald->provincia->departamento_id ))
                                                    selected="selected" @endif>{{$departamento->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="provincia" class="col-md-3 control-label" >Provincia:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" id="select-provincia-final">
                                                <option value="">Seleccione provincia</option>
                                                @foreach ($f_provincias as $f_provincia)
                                                <option value="{{$i_provincia->id}}" @if ($f_provincia->id == old('select-provincia-final', $publicacion->requerimiento->finald->provincia_id )) 
                                                    selected="selected" @endif>{{$f_provincia->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="distrito" class="col-md-3 control-label" >distrito:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" name="finaldistrito" id="select-distrito-final">
                                                <option value="">Seleccione distrito</option>
                                                @foreach ($f_distritos as $f_distrito)
                                                <option value="{{$f_distrito->id}}" @if ($f_distrito->id == old('select-distrito-final', $publicacion->requerimiento->finald_id )) 
                                                    selected="selected" @endif>{{$f_distrito->descripcion}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>  

                                    <div class="form-group">
                                        <label for="finalDireccion" class="col-md-3 control-label" >Direccion:</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="finalDireccion" autofocus value="{{ $publicacion->requerimiento->finaldireccion }}"> 
                                        </div>
                                    </div>
                                    @endif

                                    <div class="form-group">
                                        <label for="finalFecha" class="col-md-3 control-label" >Fecha:</label>

                                        <div class="col-md-8">
                                            <input type="date" class="form-control" name="finalFecha" autofocus min="<?php echo date("Y-m-d");?>" value="{{ \Carbon\Carbon::parse($publicacion->requerimiento->finalfecha)->format('Y-m-d')}}"> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend  style="font-size: 15px;"><b>Maxima Fecha para encontrar unidades</b></legend>
                                
                                <div class="col-sm-offset-1">
                                    <div class="form-group col-md-6">
                                        <label for="maximaFecha" class="col-md-4 control-label" >Fecha:</label>

                                        <div class="col-md-8 input-move">
                                            <input type="date" class="form-control" name="maximaFecha" autofocus min="<?php echo date("Y-m-d");?>" value="{{ \Carbon\Carbon::parse($publicacion->requerimiento->maximafecha)->format('Y-m-d')}}">  
                                        </div>
                                    </div>


                                    <div class="form-group col-md-6">
                                        <label for="maximaHora" class="col-md-4 control-label" >Hora:</label>

                                        <div class="col-md-8">
                                             <input type="time" class="form-control" name="maximaHora" autofocus value="{{ \Carbon\Carbon::parse($publicacion->requerimiento->maximafecha)->format('H:i')}}"> 
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            @if($publicacion->estado == "Nuevo")
                            <fieldset>
                                <legend  style="font-size: 15px;"><b>Información de unidades</b></legend>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="unidadCantidad" class="col-md-3 control-label" >Cantidad de Unidades:</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="unidadCantidad" autofocus value="{{ $publicacion->requerimiento->unidadcantidad }}"> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="unidadTipo" class="col-md-3 control-label" >Tipo de unidad:</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="unidadTipo" autofocus value="{{ $publicacion->requerimiento->unidadtipo }}"> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="unidadRequisito" class="col-md-3 control-label" >Requisitos:</label>

                                        <div class="col-md-8">
                                            <textarea name="unidadRequisito" class="form-control" autofocus>{{ $publicacion->requerimiento->unidadrequisito }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <fieldset>
                                <legend  style="font-size: 15px;"><b>Informacion de pago</b></legend>
                                
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pagoMetodo" class="col-md-3 control-label" >Metodo de Pago:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" name="pagoMetodo" id="pagoMetodo">
                                                <option value="contado" @if( old('pagometodo', $publicacion->requerimiento->pagometodo) == 'contado') selected="selected" @endif>Contado</option>
                                                <option value="credito" @if( old('pagometodo', $publicacion->requerimiento->pagometodo) == 'credito') selected="selected" @endif>Credito</option>
                                            </select>  
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="pagoMoneda" class="col-md-3 control-label" >Moneda de Pago:</label>

                                        <div class="col-md-8">
                                            <select class="form-control" name="pagoMoneda" id="pagoMoneda">
                                                <option value="sol" @if( old('pagometodo', $publicacion->requerimiento->pagomoneda) == 'sol') selected="selected" @endif>Soles</option>
                                                <option value="dol" @if( old('pagometodo', $publicacion->requerimiento->pagomoneda) == 'dol') selected="selected" @endif>Dolares</option>
                                            </select> 
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="pagoMonto" class="col-md-3 control-label" >Monto de Pago:</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                              <input type="text" class="form-control" name="pagoMonto" aria-describedby="basic-addon2" value="{{ $publicacion->requerimiento->pagomonto }}">
                                              <span class="input-group-addon" id="moneda">
                                                @if ($publicacion->requerimiento->pagomoneda == 'sol') sol
                                                @else dol
                                                @endif
                                              </span>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                    <div class="form-group" id="qDias" style="
                                        @if( old('qDias', $publicacion->requerimiento->pagometodo) == 'contado') display:none 
                                        @else display:block
                                        @endif
                                    ">
                                        <label for="cantDias" class="col-md-3 control-label" >Cantidad de dias:</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                              <input type="text" class="form-control" name="cantDias" aria-describedby="basic-addon2" value="{{$publicacion->requerimiento->cantdias}}">
                                              <span class="input-group-addon" id="basic-addon2">dias</span>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="cantDias" class="col-md-3 control-label" >Adicionales:</label>

                                        <div class="col-md-8">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="igv" @if( old('igv', $publicacion->requerimiento->igv) == '1') checked="ckecked" @endif> igv</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="seguro" @if( old('igv', $publicacion->requerimiento->seguro) == '1') checked="ckecked" @endif > seguro</label>
                                            </div>
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="porTn" @if( old('igv', $publicacion->requerimiento->portn) == '1') checked="ckecked" @endif > por Tn</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            @endif
                        

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle del Publicacion</b></legend>
                            
                            @if($publicacion->estado != "Cerrado")
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="pagoMonto" class="col-md-3 control-label" >Monto de Pago:</label>

                                        <div class="col-md-8">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="pagoPublicacion" aria-describedby="basic-addon2" value="{{ $publicacion->pagomonto }}">
                                                <span class="input-group-addon" id="moneda">sol</span>
                                            </div> 
                                        </div>
                                    </div> 
                                </div>
                            @endif

                            <div class="col-sm-offset-1">
                                <div class="form-group col-md-6">
                                    <label for="fechaExpiracion" class="col-md-4 control-label" >Fecha:</label>

                                    <div class="col-md-8 input-move"> 
                                        <input type="date" class="form-control" name="expiracionFecha" autofocus min="<?php echo date("Y-m-d");?>" value="{{ \Carbon\Carbon::parse($publicacion->fechaexpiracion)->format('Y-m-d')}}"> 
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="horaExpiracion" class="col-md-4 control-label" >Hora:</label>

                                    <div class="col-md-8">
                                        <input type="time" class="form-control" name="expiracionHora" value="{{ \Carbon\Carbon::parse($publicacion->fechaexpiracion)->format('H:i')}}"> 
                                    </div>
                                </div>    
                            </div>                             
                        </fieldset>  

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Editar requerimiento
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
    <script src="{{ asset('/js/Publicacion/publicacion.js') }}"></script>
@endsection

