<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PruebasController extends Controller
{
    public function index(){
        $mensaje = 'Funciona?';
        return view('Pruebas.index',compact('mensaje'));
    }

    public function cargarJson($ruta, $chunksize){
        $archivoJson = file_get_contents(storage_path($ruta));

        if ($archivoJson === false){
            die('Error al cargar el JSON');
        }

        $datos = json_decode($archivoJson, true);

        // Asignar tamño del chunk - 61,084 -> 5s (soportado)
        // datos[0] por ser inecesariamente una matriz de 3 dimensiones
        $datos  = array_chunk($datos[0], $chunksize);
        if($datos === null){
            die('Error al decodificar JSON.');
        }
        return $datos[0];
    }

    public function asignarIndice($arreglo) {
        $data = array();

        foreach( $arreglo as $registro){
            $data[mb_strtolower($registro[0])] = $registro;
        }

        return $data;
    }

//Vista real
    public function reporte(){
        $chunksize = 10000;
        // Cuncks de datos Contenidos Especializados - General (PLATAFORMA) - Oferta Educativa
        $chunk_CE  = self::cargarJson('app/archivos/matriculas.json', $chunksize);
        $chunk_GENERAL_GN   = self::asignarIndice(self::cargarJson('app/archivos/GN.json', $chunksize));
        $chunk_GENERAL_SDN  = self::asignarIndice(self::cargarJson('app/archivos/SDN.json', $chunksize));


        $gn_CE = 0; $sdn_CE = 0; $Contenidos_Especializados = 0;
        $gn_periodo = 0; $gn_historico = 0; $gn_GENERAL = 0;
        $sdn_periodo = 0; $sdn_historico = 0; $sdn_GENERAL = 0;




        foreach ($chunk_CE as $dato) {
            $sdn_CE += $dato[2];
            $gn_CE += $dato[3];
            $Contenidos_Especializados += $dato[4];
        }

        foreach ($chunk_GENERAL_GN as $dato) {
            $gn_periodo += $dato[1];
            $gn_historico += $dato[2];
            $gn_GENERAL += $dato[3];
        }

        foreach ($chunk_GENERAL_SDN as $dato) {
            $sdn_periodo += $dato[1];
            $sdn_historico += $dato[2];
            $sdn_GENERAL += $dato[3];
        }


        $totales = [
            'sdn_CE' => $sdn_CE,
            'gn_CE' => $gn_CE,
            'Contenidos_Especializados' => $Contenidos_Especializados,

            'gn_periodo' => $gn_periodo,
            'gn_historico' => $gn_historico,
            'gn_GENERAL' => $gn_GENERAL,

            'sdn_periodo' => $sdn_periodo,
            'sdn_historico' => $sdn_historico,
            'sdn_GENERAL' => $sdn_GENERAL,
        ];

        // print_r($chunk_GENERAL_SDN);
        return view('Pruebas.reporte_sdn_gn',compact('chunk_CE','chunk_GENERAL_GN', 'chunk_GENERAL_SDN', 'totales'));
    }

}
