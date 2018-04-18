$(function() {
    $('[data-tab]').on('click', postulacion_detalle);

    $('#form-reg-seleccion').on('submit', function () {
        event.preventDefault();
        var $formRegister = $('#form-reg-seleccion');
        var registerUrl = $formRegister.attr('action');

        console.log($formRegister.serialize());
        console.log(registerUrl);

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
                                    'Seleccion se envio correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/postulaciones/publicaciones";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });       
    })
})

function postulacion_detalle() {
    var id = $(this).data('tab');

    if (id != '') {
        var tab = '';
        //AJAX
        $.get('/postulaciones/detalle/'+id, function (data) {
            console.log(data);
            for (var i = 0; i < data.length; i++){
                tab += '<tr>'
                            +'<td>'+data[i].unidad.tipo+'</td>'
                            +'<td>'+data[i].unidad.modelo+'</td>'
                            +'<td>'+data[i].unidad.color+'</td>'
                            +'<td>'+data[i].unidad.anio+'</td>'
                            +'<td>'+data[i].unidad.pesobruto+'</td>'
                            +'<td>'+data[i].unidad.mtctracto +'<br>'+ data[i].unidad.placatracto+'</td>'
                            +'<td>'+data[i].unidad.mtccarreta +'<br>'+ data[i].unidad.placacarreta+'</td>'
                            +'<td>'+data[i].trabajador.nombre +' '+ data[i].trabajador.apellido+'<br> DNI: '+ data[i].trabajador.dni+'</td>'
                            +'<td><input type="checkbox" class="form-check-input" name="seleccion[]" value="'+data[i].id+'"></td>'+
                        '</tr>'

            }

            $('#acordion'+id).find('.tbody').html(tab); 
            $('#acordion'+id).collapse("toggle");
        })

    }
}
