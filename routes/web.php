<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();	

//Formulario de usuarios
Route::get('/generador', 'EmpresaController@createG');
Route::get('/transportista', 'EmpresaController@createT');

//Obtener datos
Route::get('/departamento/{id}/provincias', 'UbigeoController@getProvincia');
Route::get('/provincia/{id}/distritos', 'UbigeoController@getDistrito');

//Registrar Usuarios
Route::post('/generador/registro', 'EmpresaController@storeG');
Route::post('/transportista/registro', 'EmpresaController@storeT');

//Listado de empresas
Route::get('/generador/listado', 'EmpresaController@indexG');
Route::get('/generador/editar/{id}', 'EmpresaController@editG');
Route::post('/generador/editar/{id}', 'EmpresaController@updateG');
Route::post('/generador/eliminar', 'EmpresaController@delete');

Route::get('/transportista/listado', 'EmpresaController@indexT');
Route::get('/download/{file}' , 'EmpresaController@downloadFile');
Route::get('/transportista/editar/{id}', 'EmpresaController@editT');
Route::post('/transportista/editar/{id}', 'EmpresaController@updateT');
Route::post('/transportista/eliminar', 'EmpresaController@delete');

//Editar empresa
Route::get('/empresa/editar', 'EmpresaController@editE');

//Login
Route::get('/home', 'HomeController@home');

//Requerimiento
Route::get('/requerimiento/nuevo', 'GenRequerimientoController@create');
Route::post('/requerimiento/nuevo', 'GenRequerimientoController@store');
Route::get('/requerimiento/detalle/{id}', 'GenRequerimientoController@detailsG');
Route::get('/requerimiento/editar/{id}', 'GenRequerimientoController@edit');
Route::post('/requerimiento/editar/{id}', 'GenRequerimientoController@update');
Route::post('/requerimiento/delete', 'GenRequerimientoController@delete');

//Publicacion
Route::get('/nrequerimiento/nuevo', 'PublicacionController@createR');
Route::post('/nrequerimiento/nuevo', 'PublicacionController@storeR');
Route::get('/nrequerimiento/detalle/{id}', 'GenRequerimientoController@detailsA');
Route::post('/nrequerimiento/rechazar', 'GenRequerimientoController@deny');

Route::get('/publicacion/listado', 'PublicacionController@index');
Route::get('/publicacion/nuevo/{id}', 'PublicacionController@createP');
Route::post('/publicacion/nuevo/{id}', 'PublicacionController@storeP');
Route::get('/publicacion/detalle/{id}', 'PublicacionController@detailsA');
Route::get('/publicacion/editar/{id}', 'PublicacionController@edit');
Route::post('/publicacion/editar/{id}', 'PublicacionController@updateN');
Route::post('/publicacion/modificada/editar/{id}', 'PublicacionController@updateM');
Route::post('/publicacion/eliminar', 'PublicacionController@delete');

//Tran Trabajador
Route::get('/trabajador/listado', 'TranTrabajadorController@index');
Route::get('/trabajador/nuevo', 'TranTrabajadorController@create');
Route::post('/trabajador/nuevo', 'TranTrabajadorController@store');
Route::get('/trabajador/editar/{id}', 'TranTrabajadorController@edit');
Route::post('/trabajador/editar/{id}', 'TranTrabajadorController@update');
Route::post('/trabajador/delete', 'TranTrabajadorController@delete');
Route::get('/trabajador/detalle/{id}', 'TranTrabajadorController@getTrabajadores');

//Tran Unidad
Route::get('/unidad/listado', 'TranUnidadController@index');
Route::get('/unidad/nuevo', 'TranUnidadController@create');
Route::post('/unidad/nuevo', 'TranUnidadController@store');
Route::get('/unidad/visto/{id}', 'TranUnidadController@details');
Route::get('/unidad/editar/{id}', 'TranUnidadController@edit');
Route::post('/unidad/editar/{id}', 'TranUnidadController@update');
Route::post('/unidad/delete', 'TranUnidadController@delete');


//postulacion
Route::get('/npublicacion/detalle/{id}', 'PublicacionController@detailsT');
Route::post('/npublicacion/rechazar', 'PublicacionController@deny');

Route::get('/postulacion/listado', 'PostulacionController@index');
Route::get('/postulacion/nuevo/{id}', 'PostulacionController@create');
Route::post('/postulacion/nuevo/{id}', 'PostulacionController@store');
Route::get('/postulacion/detalle/{id}', 'PostulacionController@details');
Route::get('/postulacion/editar/{id}', 'PostulacionController@edit');
Route::post('/postulacion/editar/{id}', 'PostulacionController@update');
Route::post('/postulacion/eliminar', 'PostulacionController@delete');

Route::get('/postulaciones/publicaciones', 'SeleccionController@listadoPb');
Route::get('/postulaciones/{id}', 'SeleccionController@listadoPo');
Route::get('/postulaciones/detalle/{id}', 'SeleccionController@detailsPo');
Route::post('/seleccion/nuevo/{id}', 'SeleccionController@store');
Route::get('/seleccion/detalle/{id}', 'SeleccionController@detailsSe');

//notificaciones
Route::get('/nrequerimiento', 'NotificacionController@nrequerimiento');
Route::get('/npublicacion', 'NotificacionController@npublicacion');
Route::get('/npostulacion', 'NotificacionController@npostulacion');

Route::post('/httpush/nrequerimiento', 'NotificacionController@httpushR');
Route::post('/mensaje/nrequerimiento', 'NotificacionController@mensajeR');
Route::post('/httpush/npublicacion', 'NotificacionController@httpushPb');
Route::post('/mensaje/npublicacion', 'NotificacionController@mensajePb');
Route::post('/httpush/npostulacion', 'NotificacionController@httpushPo');
Route::post('/mensaje/npostulacion', 'NotificacionController@mensajePo');

//graficos
Route::get('listado_graficas', 'GraficosController@index');
Route::get('/grafico/usuario/{anio}', 'GraficosController@graficousuario');
Route::get('/grafico/requerimiento/{anio}', 'GraficosController@graficorequerimiento');
Route::get('/grafico/postulacion/{anio}', 'GraficosController@graficopostulacion');

//reporte
Route::get('/excel/reporte/{id}', 'GraficosController@reporteexcel');