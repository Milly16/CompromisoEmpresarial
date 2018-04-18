$(function() {
    $('#select-departamento').on('change',onSelectDepartamentoChange);
    $('#select-provincia').on('change',onSelectProvinciaChange);

    $("input[name=ruc]").on('input', numbers);
    $("input[name=contTelefono]").on('input', numbers);
    
    $('#form-reg-transportista').on('submit', function () {
        event.preventDefault();
        var $formRegister = $('#form-reg-transportista');
        var registerUrl = $formRegister.attr('action');

        $.ajax({
            url: registerUrl,
            method: 'POST',
            data: new FormData(this),
            processData: false,
            contentType: false,
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
                                    'Empresa se registro correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/login";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    })

    $('#form-edit-transportista').on('submit', function () {
        event.preventDefault();
        var $formEdit = $('#form-edit-transportista');
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
                                    'Empresa Transportista se edito correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/transportista/listado";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    });

    $('[data-delete]').on('click', function () {
        var id = $(this).data('delete');

        $('#form-del-transportista').find('[name="id"]').val(id);
        $("#modal-delete").modal();
    });

    $('#delete-transportista').on('click', function () {
        event.preventDefault();
        var $formDelete = $('#form-del-transportista');
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
                                    'Transportista se elimino correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/transportista/listado";
                        }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
    });

    $("#buscar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabla tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
})

function onSelectDepartamentoChange () {
    var departamento_id=$(this).val();

    $('#select-provincia').empty().html('<option value="">Seleccione provincia</option>');
    $('#select-distrito').empty().html('<option value="">Seleccione distrito</option>');
    if (departamento_id != '') {
    
        //AJAX
        $.get('/departamento/'+departamento_id+'/provincias', function (data) {
                
            var provincia_html = '<option value="">Seleccione provincia</option>';
            for (var i = 0; i < data.length; i++)
                provincia_html += '<option value="'+data[i].id+'">'+data[i].descripcion+'</option>';
            /*console.log(provincia_html);*/
            $('#select-provincia').html(provincia_html);
                
        })

    }
}

function onSelectProvinciaChange () {
    var provincia_id=$(this).val();
    $('#select-distrito').empty().html('<option value="">Seleccione distrito</option>');

    //AJAX
    if (provincia_id != '') {
    
        //AJAX
        $.get('/provincia/'+provincia_id+'/distritos', function (data) {
                
            var distrito_html = '<option value="">Seleccione distrito</option>';
            for (var i = 0; i < data.length; i++)
                distrito_html += '<option value="'+data[i].id+'">'+data[i].descripcion+'</option>';
            /*console.log(distrito_html);*/
            $('#select-distrito').html(distrito_html);
                
        })

    }
}

function numbers () { 
    this.value = this.value.replace(/[^0-9]/g,'');
}