$(function() {
    $('#nrequerimiento-img').on('click', requerimiento_nuevo);
    $('#npublicacion-img').on('click', publicacion_nuevo);
    $('#npostulacion-img').on('click', postulacion_nuevo);
});

function requerimiento_nuevo() {
    
    var nrequerimiento = '<li class="dropdown-header">Nuevos Requerimientos</li><li class="divider" ></li>';
    $.get('/nrequerimiento', function (data) {
        
        console.log(data);
        for (var i = 0; i < data.length; i++){
            nrequerimiento +=   '<li>'
                                    +'<a href=/nrequerimiento/detalle/'+data[i].id+'>'
                                        +data[i].producto+' '+data[i].pesoneto+data[i].pesounidad+'<br>'
                                        +data[i].iniciofecha
                                    +'</a>'
                                +'</li>'
                                +'<li class="divider"></li>'

        }

        $( "#nrequerimiento-list" ).html(nrequerimiento);
    });   
}

function publicacion_nuevo() {
    
    var npublicacion = '<li class="dropdown-header">Nuevas Publicaciones</li><li class="divider" ></li>';
    $.get('/npublicacion', function (data) {
        
        console.log(data);
        for (var i = 0; i < data.length; i++){
            npublicacion +=   '<li>'
                                    +'<a href=/npublicacion/detalle/'+data[i].id+'>'
                                        +data[i].requerimiento.producto+' '+data[i].requerimiento.pesoneto+data[i].requerimiento.pesounidad+'<br>'
                                        +data[i].requerimiento.iniciod.descripcion+'-'+data[i].requerimiento.finald.descripcion
                                    +'</a>'
                                +'</li>'
                                +'<li class="divider"></li>'

        }

        $( "#npublicacion-list" ).html(npublicacion);
    });   
}

function postulacion_nuevo() {
    
    var npostulacion = '<li class="dropdown-header">Nuevas Postulaciones</li><li class="divider" ></li>';
    $.get('/npostulacion', function (data) {
        
        console.log(data);
        for (var i = 0; i < data.length; i++){
            npostulacion +=   '<li>'
                                    +'<a href=/postulaciones/'+data[i].publicacion_id+'>'
                                        +data[i].razonSocial+' ('+data[i].detalle+' unid)'+'<br>'
                                        +data[i].Di+'-'+data[i].Df
                                    +'</a>'
                                +'</li>'
                                +'<li class="divider"></li>'

        }
       
        $( "#npostulacion-list" ).html(npostulacion);
    });   
}
