@extends('layouts.appA')

@section('content')


<div class="container">
    <div class="row">
        <div class="box-alert">
            
        </div>

        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><b>REGISTRAR NUEVO REQUERIMIENTO</b></div>


                <div class="panel-body">

                    <form class="form-horizontal" method="POST" id="form-reg-reqerimiento" action="{{ url('/nrequerimiento/nuevo') }}">
                        {{ csrf_field() }}

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle de la carga</b></legend>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="producto" class="col-md-3 control-label" >Producto:</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="producto" autofocus> 
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-offset-1">
                                <div class="form-group col-md-6">
                                    <label for="pesoNeto" class="col-md-4 control-label" >Peso Neto:</label>

                                    <div class="col-md-8 input-move">
                                        <input type="text" class="form-control" name="pesoNeto" autofocus> 
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="pesoUnidad" class="col-md-4 control-label" >Unidad:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" name="pesoUnidad">
                                            <option value="Kg">Kilogramo</option>
                                            <option value="Tn">Tonelada</option>
                                            <option value="Lb">Libra</option>
                                            <option value="Lt">Litro</option>
                                            <option value="M3">Metros cúbico</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Recojer la carga ...</b></legend>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="departamento" class="col-md-3 control-label" >Departamento:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" id="select-departamento-inicio">
                                            <option value="">Seleccione departamento</option>
                                            @foreach ($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="provincia" class="col-md-3 control-label" >Provincia:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" id="select-provincia-inicio">
                                            <option value="">Seleccione provincia</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="distrito" class="col-md-3 control-label" >distrito:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" name="iniciodistrito" id="select-distrito-inicio">
                                            <option value="">Seleccione distrito</option>
                                        </select>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label for="inicioDireccion" class="col-md-3 control-label" >Direccion:</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="inicioDireccion" autofocus> 
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-offset-1">                        
                                <div class="form-group col-md-6">
                                    <label for="inicioFecha" class="col-md-4 control-label" >Fecha:</label>

                                    <div class="col-md-8 input-move"> 
                                        <input type="date" class="form-control" name="inicioFecha" autofocus min="<?php echo date("Y-m-d");?>"> 
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="inicioHora" class="col-md-4 control-label" >Hora:</label>

                                    <div class="col-md-8">
                                        <input type="time" class="form-control" name="inicioHora"> 
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Entregar la carga ...</b></legend>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="departamento" class="col-md-3 control-label" >Departamento:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" id="select-departamento-final">
                                            <option value="">Seleccione departamento</option>
                                            @foreach ($departamentos as $departamento)
                                                <option value="{{$departamento->id}}">{{$departamento->descripcion}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="provincia" class="col-md-3 control-label" >Provincia:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" id="select-provincia-final">
                                            <option value="">Seleccione provincia</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="distrito" class="col-md-3 control-label" >distrito:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" name="finaldistrito" id="select-distrito-final">
                                            <option value="">Seleccione distrito</option>
                                        </select>
                                    </div>
                                </div>  

                                <div class="form-group">
                                    <label for="finalDireccion" class="col-md-3 control-label" >Direccion:</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="finalDireccion" autofocus> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="finalFecha" class="col-md-3 control-label" >Fecha:</label>

                                    <div class="col-md-8">
                                        <input type="date" class="form-control" name="finalFecha" autofocus min="<?php echo date("Y-m-d");?>"> 
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
                                        <input type="date" class="form-control" name="maximaFecha" autofocus min="<?php echo date("Y-m-d");?>"> 
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="maximaHora" class="col-md-4 control-label" >Hora:</label>

                                    <div class="col-md-8">
                                        <input type="time" class="form-control" name="maximaHora" autofocus> 
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Información de unidades</b></legend>
                            
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="unidadCantidad" class="col-md-3 control-label" >Cantidad de Unidades:</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="unidadCantidad" autofocus> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="unidadTipo" class="col-md-3 control-label" >Tipo de unidad:</label>

                                    <div class="col-md-8">
                                        <input type="text" class="form-control" name="unidadTipo" autofocus> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="unidadRequisito" class="col-md-3 control-label" >Requisitos:</label>

                                    <div class="col-md-8">
                                        <textarea name="unidadRequisito" class="form-control" autofocus></textarea>
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
                                            <option value="contado">Contado</option>
                                            <option value="credito">Credito</option>
                                        </select> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="pagoMoneda" class="col-md-3 control-label" >Moneda de Pago:</label>

                                    <div class="col-md-8">
                                        <select class="form-control" name="pagoMoneda" id="pagoMoneda">
                                            <option value="sol">Soles</option>
                                            <option value="dol">Dolares</option>
                                        </select> 
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label for="pagoMonto" class="col-md-3 control-label" >Monto de Pago:</label>

                                    <div class="col-md-8">
                                        <div class="input-group">
                                          <input type="text" class="form-control" name="pagoMonto" aria-describedby="basic-addon2">
                                          <span class="input-group-addon" id="moneda">sol</span>
                                        </div> 
                                    </div>
                                </div>
                                
                                <div class="form-group" id="qDias" style="display: none;">
                                    <label for="cantDias" class="col-md-3 control-label" >Cantidad de dias:</label>

                                    <div class="col-md-8">
                                        <div class="input-group">
                                          <input type="text" class="form-control" name="cantDias" aria-describedby="basic-addon2">
                                          <span class="input-group-addon" id="basic-addon2">dias</span>
                                        </div> 
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cantDias" class="col-md-3 control-label" >Adicionales:</label>

                                    <div class="col-md-8">
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="igv"> igv</label>
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="seguro"> seguro</label>
                                        </div>
                                        <div class="checkbox">
                                            <label><input type="checkbox" name="porTn"> por Tn</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend  style="font-size: 15px;"><b>Detalle del Publicacion</b></legend>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="pagoMonto" class="col-md-3 control-label" >Monto de Pago:</label>

                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="pagoPublicacion" aria-describedby="basic-addon2">
                                            <span class="input-group-addon" id="moneda">sol</span>
                                        </div> 
                                    </div>
                                </div> 
                            </div>

                            <div class="col-sm-offset-1">
                                <div class="form-group col-md-6">
                                    <label for="fechaExpiracion" class="col-md-4 control-label" >Fecha:</label>

                                    <div class="col-md-8 input-move"> 
                                        <input type="date" class="form-control" name="expiracionFecha" autofocus min="<?php echo date("Y-m-d");?>"> 
                                    </div>
                                </div>


                                <div class="form-group col-md-6">
                                    <label for="horaExpiracion" class="col-md-4 control-label" >Hora:</label>

                                    <div class="col-md-8">
                                        <input type="time" class="form-control" name="expiracionHora"> 
                                    </div>
                                </div>    
                            </div>


                                                    
                        </fieldset>  

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Registrar requerimiento
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
    <script src="{{ asset('/js/Requerimiento/requerimiento.js') }}"></script>
@endsection

