<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Modelo\Requerimiento\GenRequerimiento;
use App\Modelo\Publicacion\Publicacion;
use App\Modelo\Usuario\Usuario;
use App\Modelo\PostulacionSeleccion\Seleccion;
use App\Modelo\PostulacionSeleccion\Postulacion;
use App\Modelo\PostulacionSeleccion\PostulacionDetalle;

use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use PHPExcel_Style_Alignment;
use PHPExcel_Worksheet_Drawing;

class GraficosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*$usuarios = Usuario::where('tipo_usuario_id', '!=', 1)
                    ->get();

      
        foreach ($usuarios as $usuario) {
            $usuario_año = Carbon::parse($usuario->creadofecha)->format('Y'); 
  
        }*/

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');

        return view('Reporte.graficos');      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function show(Publicacion $publicacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function edit(Publicacion $publicacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publicacion $publicacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publicacion  $publicacion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publicacion $publicacion)
    {
        //
    }

    public function graficousuario($anio){

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');
        /*$fechacreado = Carbon::parse($usuario->creadofecha)->format('Y');*/

        $usuarios = Usuario::whereYear('creadofecha', '=', $anio)
                        ->where('tipo_usuario_id', '!=', 1)
                        ->get();

        $array = [];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril' , 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        for ($i=0; $i < 12; $i++) { 
            $cantidad = 0;
            foreach ($usuarios as $usuario) {
                $fechacreado = Carbon::parse($usuario->creadofecha)->format('n');
                if ($i == $fechacreado-1) {
                    $cantidad ++;
                }

            }  

            /*$array[$i]['name'] = $meses[$i]; */
            /*$array[$i]['y'] = $cantidad; */
            $array[$i] = $cantidad; 
        }

        return $array;
    }

    public function graficorequerimiento($anio){

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');
        /*$fechacreado = Carbon::parse($requerimiento->creadofecha)->format('Y');*/

        $requerimientos = GenRequerimiento::whereYear('creadofecha', '=', $anio)
                        ->get();

        $array = [];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril' , 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        for ($i=0; $i < 12; $i++) { 
            $cantidad = 0;
            foreach ($requerimientos as $requerimiento) {
                $fechacreado = Carbon::parse($requerimiento->creadofecha)->format('n');
                if ($i == $fechacreado-1) {
                    $cantidad ++;
                }

            }  

            /*$array[$i]['name'] = $meses[$i]; */
            /*$array[$i]['y'] = $cantidad; */
            $array[$i] = $cantidad; 
        }

        return $array;
    }

    public function graficopostulacion($anio){

        if (Auth::guest()) 
            return redirect('login');

        if (Auth::user()->tipo_usuario_id != 1)
            return redirect('home');
        /*$fechacreado = Carbon::parse($requerimiento->creadofecha)->format('Y');*/

        $postulaciones = Postulacion::whereYear('creadofecha', '=', $anio)
                        ->get();


        $array = [];
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril' , 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        for ($i=0; $i < 12; $i++) { 
            $cantidad = 0;
            foreach ($postulaciones as $postulacion) {
                $fechacreado = Carbon::parse($postulacion->creadofecha)->format('n');
                if ($i == $fechacreado-1) {
                    $cantidad ++;
                }

            }  

            /*$array[$i]['name'] = $meses[$i]; */
            /*$array[$i]['y'] = $cantidad; */
            $array[$i] = $cantidad; 
        }

        return $array;
    }

    public function reporteexcel($id)
    {
        
        $nameExcel = 'Informe '.$id;

        Excel::create($nameExcel, function($excel) use ($id) {
 
            $excel->sheet('Informe', function($sheet) use($id){

                $sheet->mergeCells('B2:H2');
                $sheet->setCellValue('B2', 'DETALLE DEL SERVICIO REALIZADO Nº '.$id); 

                $sheet->cell('B2', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setFontWeight('bold');
                });

                $sheet->setCellValue('B4', 'EMPRESA:'); 
                $sheet->setCellValue('B5', 'CARGA:'); 
                $sheet->setCellValue('B6', 'RECOGER EN:'); 
                $sheet->setCellValue('B10', 'PAGO POR SERVICIO:'); 
                $sheet->setCellValue('B11', 'PAGO POR PUBLICACION:'); 

                $sheet->cells('B4:B11', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->setCellValue('E4', 'RUC:'); 
                $sheet->setCellValue('E5', 'PESO:'); 
                $sheet->setCellValue('E6', 'ENTREGAR EN:'); 

                $sheet->cells('E4:E6', function($cells) {
                    $cells->setFontWeight('bold');
                });

                $sheet->cell('A13', function($cell) {
                    $cell->setAlignment('center');
                    $cell->setFontWeight('bold');
                });

                $sheet->cells('A14:S14', function($cells) {
                    $cells->setBackground('#80adc5');
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->setWidth('A', 10);
                $sheet->setWidth('B', 24);
                $sheet->setWidth('C', 30);
                $sheet->setWidth('D', 18);
                $sheet->setWidth('E', 16);
                $sheet->setWidth('F', 22);
                $sheet->setWidth('G', 13);
                $sheet->setWidth('H', 13);
                $sheet->setWidth('I', 13);
                $sheet->setWidth('J', 15);
                $sheet->setWidth('K', 15);
                $sheet->setWidth('L', 15);
                $sheet->setWidth('M', 15);                
                $sheet->setWidth('N', 15);
                $sheet->setWidth('O', 13);
                $sheet->setWidth('P', 23);
                $sheet->setWidth('Q', 13);
                $sheet->setWidth('R', 13);
                $sheet->setWidth('S', 13);


                $publicacion = Publicacion::find($id);

                $moneda = ($publicacion->requerimiento->pagomoneda=='sol') ? 'S/.' : '$';

                $sheet->setCellValue('C4', $publicacion->requerimiento->empresagen->empresa->razonsocial); 
                $sheet->setCellValue('C5', $publicacion->requerimiento->producto); 
                $sheet->setCellValue('C6', $publicacion->requerimiento->iniciodireccion); 
                $sheet->setCellValue('C7', $publicacion->requerimiento->iniciod->descripcion.' - '.$publicacion->requerimiento->iniciod->provincia->descripcion.' - '.$publicacion->requerimiento->iniciod->provincia->departamento->descripcion); 
                $sheet->setCellValue('C8', \Carbon\Carbon::parse($publicacion->requerimiento->iniciofecha)->format('d-m-Y H:i')); 
                $sheet->setCellValue('C10', $moneda.' '.$publicacion->requerimiento->pagomonto); 
                $sheet->setCellValue('C11', 'S/.'.' '.$publicacion->pagomonto); 
                $sheet->setCellValue('F4', $publicacion->requerimiento->empresagen->empresa->ruc); 
                $sheet->setCellValue('F5', $publicacion->requerimiento->pesounidad); 
                $sheet->setCellValue('F6', $publicacion->requerimiento->finaldireccion); 
                $sheet->setCellValue('F7', $publicacion->requerimiento->finald->descripcion.' - '.$publicacion->requerimiento->finald->provincia->descripcion.' - '.$publicacion->requerimiento->finald->provincia->departamento->descripcion); 
                $sheet->setCellValue('F8', \Carbon\Carbon::parse($publicacion->requerimiento->finalfecha)->format('d-m-Y H:i')); 
                $sheet->setCellValue('A13', 'Detalle:');

                $sheet->row(14, ['Nº', 'RUC', 'EMPRESA TRANSPORTISTA', 'TIPO', 'MARCA', 'MODELO', 'COLOR', 'AÑO', 'PESO BRUTO', 'PLACA TRACTO', 'MTC TRACTO', 'PLACA CARRETA', 'MTC CARRETA', 'SOAT', 'FECHA SOAT', 'TRABAJADOR', 'DNI', 'CELULAR', 'BREVETE']);
                
                $selecciones = Seleccion::where('publicacion_id', $id)
                            ->with(array('postulaciondetalles' => function($query) {
                                $query->with('unidad')
                                    ->with('trabajador')
                                    ->with(array('postulacion' => function($query) {
                                        $query->with(array('empresatran' => function($query) {
                                            $query->with('empresa');
                                        }));
                                    }));
                            }))
                            ->get();

                $i = 0;
                foreach ($selecciones as $seleccion){
                    $row = [];
                    $row[0] = $i+1;
                    $row[1] = $seleccion->postulaciondetalles->postulacion->empresatran->empresa->ruc;
                    $row[2] = $seleccion->postulaciondetalles->postulacion->empresatran->empresa->razonsocial;
                    $row[3] = $seleccion->postulaciondetalles->unidad->tipo;
                    $row[4] = $seleccion->postulaciondetalles->unidad->marca;
                    $row[5] = $seleccion->postulaciondetalles->unidad->modelo;
                    $row[6] = $seleccion->postulaciondetalles->unidad->color;
                    $row[7] = $seleccion->postulaciondetalles->unidad->anio;
                    $row[8] = $seleccion->postulaciondetalles->unidad->pesobruto;
                    $row[9] = $seleccion->postulaciondetalles->unidad->placatracto;
                    $row[10] = $seleccion->postulaciondetalles->unidad->mtctracto;
                    $row[11] = $seleccion->postulaciondetalles->unidad->placacarreta;
                    $row[12] = $seleccion->postulaciondetalles->unidad->mtccarreta;
                    $row[13] = $seleccion->postulaciondetalles->unidad->nsoat;
                    $row[14] = $seleccion->postulaciondetalles->unidad->fechasoat;
                    $row[15] = $seleccion->postulaciondetalles->trabajador->nombre.' '.$seleccion->postulaciondetalles->trabajador->apellido;
                    $row[16] = $seleccion->postulaciondetalles->trabajador->dni;
                    $row[17] = $seleccion->postulaciondetalles->trabajador->celular;
                    $row[18] = $seleccion->postulaciondetalles->trabajador->brevete;
                    $sheet->appendRow($row);
                    $i += 1;
                }


            });
        })->export('xls');
    }
}


