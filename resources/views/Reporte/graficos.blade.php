@extends('layouts.appA')

@section('content')


<div class="container">
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Generar gráfico de requerimientos realizados satisfactoriamente</b></div>
                <div class="panel-body">
	                <b>Seleccione un año:</b> <select name="" id="anio-usuario">
	                	<option value="2016">2016</option>
						<option value="2017">2017</option>
						<option selected value="2018">2018</option>
					</select>
                	<br>

                	<div id="container-usuario" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    
                </div>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Generar gráfico de requerimientos recibidos por tipo de unidad</b></div>
                <div class="panel-body">
                    <b>Seleccione un año:</b> <select name="" id="anio-requerimiento">
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option selected value="2018">2018</option>
                    </select>
                    <br>

                    <div id="container-requerimiento" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    
                </div>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Generar gráfico de requerimientos recibidos por tipo de producto</b></div>
                <div class="panel-body">
                    <b>Seleccione un año:</b> <select name="" id="anio-postulacion">
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option selected value="2018">2018</option>
                    </select>
                    <br>

                    <div id="container-postulacion" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                    
                </div>
            </div>
        </div>
    </div>
</div>


@endsection


@section('scripts')
    <script src="{{ asset('/template/js/highcharts.js') }}"></script>
    <script src="{{ asset('js/Reporte/graficas.js') }}"></script>
@endsection


