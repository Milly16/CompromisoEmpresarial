$(function() {
	$("input[name=dni]").on('input', numbers);
	$("input[name=celular]").on('input', numbers);

    $('[data-view]').on('click', function() {
        var id = $(this).data('view');
        var nro = $(this).data('nro');
        viewWorker(id, nro);
    } );

    $('#form-reg-trabajador').on('submit', function () {
		event.preventDefault();
		var $formRegister = $('#form-reg-trabajador');
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
                    				'Trabajador se registro correctamente'+
                    				'</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
	                        window.location.href = "/trabajador/listado";
	                    }, 1800);
                    
                }
            },
            error: function (data) {
                // Render the errors with js ...
                console.log(data);
            }
        });
	})

    $('#form-edit-trabajador').on('submit', function () {
        event.preventDefault();
        var $formEditar = $('#form-edit-trabajador');
        var editUrl = $formEditar.attr('action');

        $.ajax({
            url: editUrl,
            method: 'POST',
            data: $formEditar.serialize(),
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
                                    'Trabajador se edito correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/trabajador/listado";
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

        $('#form-del-trabajador').find('[name="id"]').val(id);
        $("#modal-delete").modal();
    });

    $('#delete-trabajador').on('click', function () {
        event.preventDefault();
        var $formDelete = $('#form-del-trabajador');
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
                                    'Trabajador se elimino correctamente'+
                                    '</div>';
                        $('.box-alert').append( alert );
                        setTimeout(function(){
                            window.location.href = "/trabajador/listado";
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

function numbers () { 
    this.value = this.value.replace(/[^0-9]/g,'');
}

function viewWorker(id,nro) {
    event.preventDefault();
    $('.nro').html(nro);
    if (id != '') {
    
        //AJAX
        $.get('/trabajador/detalle/'+id, function (data) {
                
            for (var i = 0; i < data.length; i++){
                $('#dni').html(data[i].dni);
                $('#nombre').html(data[i].nombre);
                $('#apellido').html(data[i].apellido);
                $('#celular').html(data[i].celular);
                $('#direccion').html(data[i].direccion);

                var fecha = data[i].nacimiento;
                var parts = fecha.split('-');
                $('#fechNacimiento').html(parts[2] + '-' + parts[1] + '-' + parts[0]);
                $('#brevete').html(data[i].brevete);
            }
                
        })

        $('#modal-details').modal('show');


    }
}
