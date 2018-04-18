$(function() {
    var fecha = new Date();
    var anio = fecha.getFullYear();
    usuario_grafico(anio);
    requerimiento_grafico(anio);
    postulacion_grafico(anio);

          

    $('#anio-usuario').on('change', function(){
        var anio =$(this).val();                     
        usuario_grafico(anio);
    });

    $('#anio-requerimiento').on('change', function(){
        var anio =$(this).val();                     
        requerimiento_grafico(anio);
    });

    $('#anio-postulacion').on('change', function(){
        var anio =$(this).val();                     
        postulacion_grafico(anio);
    });

});


function usuario_grafico (anio) {
    $.get('/grafico/usuario/'+anio, function (data) {

            console.log(data);

             // Create the chart
            Highcharts.chart('container-usuario', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numeros de Usuarios registrados en el año '+anio
                },
                xAxis: {
                    categories: [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Juno',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Numero de usuarios',
                    data: data
                }]
            });

        }); 
}

function requerimiento_grafico (anio) {
    $.get('/grafico/requerimiento/'+anio, function (data) {

            console.log(data);

             // Create the chart
            Highcharts.chart('container-requerimiento', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numeros de Requerimientos Recibidos en el año '+anio
                },
                xAxis: {
                    categories: [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Juno',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Numero de requerimiento',
                    data: data
                }]
            });

        }); 
}

function postulacion_grafico (anio) {
    $.get('/grafico/postulacion/'+anio, function (data) {

            console.log(data);

             // Create the chart
            Highcharts.chart('container-postulacion', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Numeros de Postulaciones Recibidas en el año '+anio
                },
                xAxis: {
                    categories: [
                        'Enero',
                        'Febrero',
                        'Marzo',
                        'Abril',
                        'Mayo',
                        'Juno',
                        'Julio',
                        'Agosto',
                        'Septiembre',
                        'Octubre',
                        'Noviembre',
                        'Diciembre'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: ''
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: [{
                    name: 'Numero de postulaciones',
                    data: data
                }]
            });

        }); 
}