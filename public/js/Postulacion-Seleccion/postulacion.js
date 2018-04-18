$(function() {
    $(document).on('click', '[data-seleccionar]', seleccionfila);
    $(document).on('click', '[data-eliminar]', eliminacionfila);

    $('#form-reg-postulacion').on('submit', function () {
        event.preventDefault();
        var $formRegister = $('#form-reg-postulacion');
        var registerUrl = $formRegister.attr('action');

        console.log($formRegister.serialize());

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
                                    'Postulacion se envio correctamente'+
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

    $('#form-edit-postulacion').on('submit', function () {
        event.preventDefault();
        var $formEdit = $('#form-edit-postulacion');
        var editUrl = $formEdit.attr('action');

        console.log($formEdit.serialize());

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
                                    'Postulacion se envio correctamente'+
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

    $('[data-delete]').on('click', function () {
        var id = $(this).data('delete');

        $('#form-del-postulacion').find('[name="id"]').val(id);
        $("#modal-delete").modal();
    });

    $('#eliminar-postulacion').on('click', function () {
        event.preventDefault();
        var $formDelete = $('#form-del-postulacion');
        var deleteUrl = $formDelete.attr('action');
        $.ajax({
            url: deleteUrl, 
            method: 'POST',
            data: $formDelete.serialize(),
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
                                    'Requerimiento se elimino correctamente'+
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

function seleccionfila() {
    var $tr = $(this).parents('tr');

    $(this).text('Eliminar');
    $(this).removeClass('btn-success').addClass('btn-danger');
    $(this).removeAttr('data-seleccionar').attr('data-eliminar', '');
   
    $('#tablaUnidad tbody').append($tr);
    $(this).parents("tr").children( "td[name=td]" ).css( "display", "table-cell" );
}

function eliminacionfila() {
    var $tr = $(this).parents('tr');

    $(this).text('Seleccionar');
    $(this).removeClass('btn-danger').addClass('btn-success');
    $(this).removeAttr('data-eliminar').attr('data-seleccionar', '');
    $('#tablaSeleccion tbody').append($tr);
    $(this).parents("tr").children( "td[name=td]" ).css( "display", "none" );
}