$(function() {
	$('#select-departamento-inicio').on('change', function() {
		var departamento_id=$(this).val();
		onSelectDepartamentoChange('inicio', departamento_id);
	});

	$('#select-provincia-inicio').on('change', function() {
		var provincia_id=$(this).val();
		onSelectProvinciaChange('inicio', provincia_id);
	});
	
	$('#select-departamento-final').on('change', function() {
		var departamento_id=$(this).val();
		onSelectDepartamentoChange('final', departamento_id);
	});

	$('#select-provincia-final').on('change', function() {
		var provincia_id=$(this).val();
		onSelectProvinciaChange('final', provincia_id);
	});

	$("input[name=unidadCantidad]").on('input', numbers);
	$("input[name=cantDias]").on('input', numbers);

	$('input[name=pesoNeto]').on('change',decimal);
	$('input[name=pagoMonto]').on('change',decimal);
    $('input[name=pagoPublicacion]').on('change',decimal);

    $("#buscar").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#tabla tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });

	$('select[name=pagoMetodo]').change(function(){
        var opcion= $(this).val();
        if (opcion == "contado") {
          $("#qDias").css( "display", "none" );
        }else{
          $("#qDias").css( "display", "block" );
        }
        $("input[name=cantDias]").val("");
    });

    $('select[name=pagoMoneda]').change(function(){
        var opcion= $(this).val();
        if (opcion == "sol") {
          var str = $('#moneda').html(); 
          var res = str.replace("dol", "sol");
          
          $('#moneda').html(res);
        }else{
          var str = $('#moneda').html();
          var res = str.replace("sol", "dol");
          $('#moneda').html(res);
        }
    });

    $('#form-reg-reqerimiento').on('submit', function () {
		event.preventDefault();
		var $formRegister = $('#form-reg-reqerimiento');
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
                	console.log(data);
                	var alert = '<div class="alert alert-success alert-dismissable fade in">'+
                    				'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                    				'Requerimiento se registro correctamente'+
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

        $('#form-del-requerimiento').find('[name="id"]').val(id);
        $("#modal-delete").modal();
    });

    $('#delete-requerimiento').on('click', function () {
        event.preventDefault();
        var $formDelete = $('#form-del-requerimiento');
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

	$('#form-edit-reqerimiento').on('submit', function () {
		event.preventDefault();
        var $formEdit = $('#form-edit-reqerimiento');
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
                                    'Requerimiento se edito correctamente'+
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

function onSelectDepartamentoChange (x, id) {

	$('#select-provincia-'+x).empty().html('<option value="">Seleccione provincia</option>');
	$('#select-distrito-'+x).empty().html('<option value="">Seleccione distrito</option>');
	if (id != '') {
	
		//AJAX
		$.get('/departamento/'+id+'/provincias', function (data) {
				
			var provincia_html = '<option value="">Seleccione provincia</option>';
			for (var i = 0; i < data.length; i++)
				provincia_html += '<option value="'+data[i].id+'">'+data[i].descripcion+'</option>';
			/*console.log(provincia_html);*/
			$('#select-provincia-'+x).html(provincia_html);
				
		})

	}
}

function onSelectProvinciaChange (x, id) {
	
	$('#select-distrito-'+x).empty().html('<option value="">Seleccione distrito</option>');

	//AJAX
	if (id != '') {
	
		//AJAX
		$.get('/provincia/'+id+'/distritos', function (data) {
				
			var distrito_html = '<option value="">Seleccione distrito</option>';
			for (var i = 0; i < data.length; i++)
				distrito_html += '<option value="'+data[i].id+'">'+data[i].descripcion+'</option>';
			/*console.log(distrito_html);*/
			$('#select-distrito-'+x).html(distrito_html);
				
		})

	}
}

function numbers () { 
    this.value = this.value.replace(/[^0-9]/g,'');
}

function decimal() {
    var rpta = parseFloat(this.value).toFixed(2);
    if (rpta != 'NaN') {
    	this.value = rpta;
    } else{
    	this.value = 0;
    };
};

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