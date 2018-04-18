$(function() {
    $('input[name=pagoMonto]').on('change',decimal);

    $("#buscar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabla tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

    $('#form-reg-publicacion').on('submit', function () {
        event.preventDefault();
        var $formRegister = $('#form-reg-publicacion');
        var registerUrl = $formRegister.attr('action');

        $.ajax({
            url: registerUrl,
            method: 'POST',
            data: $formRegister.serialize(),
            success: function (data) {
                console.log(data);
                if (data != "") {
                    for (var property in data) {
                        var alert = '<div class="alert alert-danger alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    '<strong>Error!</strong> '+ data[property] +
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function() {
                            $('.box-alert > .alert').fadeOut(1500);
                        },3000);
                    }
                } else {
                    var alert = '<div class="alert alert-success alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    'Publicacion se registro correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/home";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    })

    $('#form-edit-publicacion').on('submit', function () {
        event.preventDefault();
        var $formEdit = $('#form-edit-publicacion');
        var editUrl = $formEdit.attr('action');

        $.ajax({
            url: editUrl,
            method: 'POST',
            data: $formEdit.serialize(),
            success: function (data) {
                console.log(data);
                if (data != "") {
                    for (var property in data) {
                        var alert = '<div class="alert alert-danger alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    '<strong>Error!</strong> '+ data[property] +
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function() {
                            $('.box-alert > .alert').fadeOut(1500);
                        },3000);
                    }
                } else {
                    var alert = '<div class="alert alert-success alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    'Publicacion se edito correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/publicacion/listado";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    })

    $('[data-eliminar]').on('click', function () {
        var id = $(this).data('eliminar');

        $('#form-del-publicacion').find('[name="id"]').val(id);
        $("#modal-eliminar").modal();
    });

    $('[data-rechazar]').on('click', function () {
        var id = $(this).data('rechazar');

        $('#form-rech-requerimiento').find('[name="id"]').val(id);
        $("#modal-rechazar").modal();
    });

    $('#eliminar-publicacion').on('click', function () {
        event.preventDefault();
        var $formEliminar = $('#form-del-publicacion');
        var rechazarUrl = $formEliminar.attr('action');

        $.ajax({
            url: rechazarUrl, 
            method: 'POST',
            data: $formEliminar.serialize(),
            success: function (data) {
                console.log(data);
                if (isNaN(data)) {   
                    for (var property in data) {
                        var alert = '<div class="alert alert-danger alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    '<strong>Error!</strong> '+ data[property] +
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function() {
                            $('.box-alert > .alert').fadeOut(1500);
                        },3000);
                    }
                } else {
                    var alert = '<div class="alert alert-success alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    'Requerimiento se rechazo correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        $("#modal-eliminar").modal("hide");

                        $('#form-rech-requerimiento').find('[name="id"]').val(data);
                        $("#modal-rechazar").modal();

                        setTimeout(function() {
                            $('.box-alert > .alert').fadeOut(1500);
                        },3000);
                        /*setTimeout(function(){
                            window.location.href = "/home";
                        }, 1800);*/
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    });



    $('#rechazar-requerimiento').on('click', function () {
        event.preventDefault();
        var $formRechazar = $('#form-rech-requerimiento');
        var rechazarUrl = $formRechazar.attr('action');
        $.ajax({
            url: rechazarUrl, 
            method: 'POST',
            data: $formRechazar.serialize(),
            success: function (data) {
                console.log(data);
                if (data != "") {   
                    for (var property in data) {
                        var alert = '<div class="alert alert-danger alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    '<strong>Error!</strong> '+ data[property] +
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function() {
                            $('.box-alert > .alert').fadeOut(1500);
                        },3000);
                    }
                } else {
                    var alert = '<div class="alert alert-success alert-dismissable fade in">'+
                                    '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                                    'Requerimiento se rechazo correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/home";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    });

    $('#cancelar-peticion').on('click', function () {
        event.preventDefault();

        var idrequerimiento = $('#form-rech-requerimiento').find('[name="id"]').val();
        window.location.href = "/nrequerimiento/detalle/"+idrequerimiento;
    });

    $('[data-sel-detalle]').on('click', seleccion_detalle);


})

function decimal() {
    var rpta = parseFloat(this.value).toFixed(2);
    if (rpta != 'NaN') {
        this.value = rpta;
    } else{
        this.value = 0;
    };
};

function seleccion_detalle() {
    var id = $(this).data('sel-detalle');

    if (id != '') {
        var tab = '';
        //AJAX
        $.get('/seleccion/detalle/'+id, function (data) {
            console.log(data);
            for (var i = 0; i < data.length; i++){
                tab += '<tr>'
                            +'<td>'+data[i].postulaciondetalles.postulacion.empresatran.empresa.razonsocial+'<br> RUC: '+data[i].postulaciondetalles.postulacion.empresatran.empresa.ruc+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.tipo+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.modelo+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.color+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.anio+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.pesobruto+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.mtctracto +'<br>'+ data[i].postulaciondetalles.unidad.placatracto+'</td>'
                            +'<td>'+data[i].postulaciondetalles.unidad.mtccarreta +'<br>'+ data[i].postulaciondetalles.unidad.placacarreta+'</td>'
                            +'<td>'+data[i].postulaciondetalles.trabajador.nombre +' '+ data[i].postulaciondetalles.trabajador.apellido+'<br> DNI: '+ data[i].postulaciondetalles.trabajador.dni+'</td>'
                            +
                        '</tr>'

            }

            $('#modal-sel-detalle').find('.tbody').html(tab); 
            $("#modal-sel-detalle").modal();
        })

    }
}

function initMap() {
                  
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -8.250587, lng: -78.891223},
        zoom: 6
    });
          

    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
    //---------------------------------------------------------

    var localizacion = recojo; //ORIGEN
    var localizacion1 = envio;//DESTINO

    //--------------------------------------------------------
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
    //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&

    var objConfigDR ={
        map: map,
    }

    var objConfigDS={
        origin: localizacion,//latlong - Strig domicilio
        destination: localizacion1,
        travelMode: google.maps.TravelMode.DRIVING
    }

    var  ds = new google.maps.DirectionsService();
    var dr = new google.maps.DirectionsRenderer(objConfigDR);
    ds.route(objConfigDS, fnRutear);

    function fnRutear(resultados, status){
        //mostrar la linea entre A y B
        if(status == 'OK'){
            dr.setDirections(resultados);
        }else {
            alert('Error '+status);
        }
    }
}