$(function() {

    //AJAX
    var nrequerimiento = '';
    $.get('/nrequerimiento', function (data) {
        for (var i = 0; i < data.length; i++)
            nrequerimiento += '<li><a href='+data[i].id+'>'
                                    +data[i].producto+' '+data[i].pesoneto+data[i].pesounidad+'<br>'
                                    +data[i].iniciofecha
                                +'</a></li><li class="divider" id="nrequerimiento"></li>';
        /*console.log(provincia_html);*/
        $( "#nrequerimiento" ).after(nrequerimiento);
    })

    $('#rechazar').on('click', function () {
        $("#modal-rechazar").modal();
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

})

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
