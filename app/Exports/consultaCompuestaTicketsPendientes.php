<?php

namespace App\Exports;

use App\tickets;
use DB;


use Maatwebsite\Excel\Facades\Excel;


class consultaCompuestaTicketsPendientes {

    /**
    * @return \Illuminate\Support\Collection
    */
    // use WithConditionalSheets;

    public function __construct(){

    }

    // METODOS DE CONSULTA
    public function resumenSitio($coleccion, $casa) {
        $data = [
            'cantidad'      => $coleccion->where('CASA', $casa)->count(),
            'montoTotal'    => $coleccion->where('CASA', $casa)->sum('COTIZACION'),
        ];

        return $data;
    }


    public function descargar(){
    //GENERAL
        return Excel::create('Consulta de Mantenimientos Pendientes', function($excel)  {

            $excel->sheet('Resumen', function($sheet)  {
// CORRECION
                $tickets = tickets::where([
                    ['ESTATUS_ACTUAL', 'PENDIENTE'],
                    ['ESTATUS_COTIZACION','<>' ,'NO'],
                ])->get();

                $pendientes_data = [
                    'aldea'     => self::resumenSitio($tickets, 'Aldea Iztapalapa'),

                    'campeche'  => self::resumenSitio($tickets, 'Campeche'),

                    'cuautla'   => self::resumenSitio($tickets, 'Cuautla'),

                    'culiacan'  => self::resumenSitio($tickets, 'Culiacán'),

                    'saltillo'  => self::resumenSitio($tickets, 'Saltillo'),

                    'tapachula' => self::resumenSitio($tickets, 'Tapachula'),

                    'tuxtla'    => self::resumenSitio($tickets, 'Tuxtla'),

                    'veracruz'  => self::resumenSitio($tickets, 'Veracruz'),

                    'sedena'    => self::resumenSitio($tickets, 'Sedena'),

                    'semar'     => self::resumenSitio($tickets, 'Semar'),
                ];

                $totales_data = [
                    'cantidad'   => $tickets->count(),
                    'montoTotal' => $tickets->sum('COTIZACION'),
                ];


                $sheet->loadView('exports.ticketPendientesGeneral', [
                    'pendientes_data'   => $pendientes_data,
                    'totales_data'      => $totales_data,
                ]);

                // AJUSTAR AL CONTENIDO
                $sheet->getStyle('A1:C13' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);

            });

            $excel->sheet('Detalle General', function($sheet)  {

                $sheet->loadView('exports.tickets', [
                    // CORRECION
                    'tickets' => tickets::where([
                                    ['ESTATUS_ACTUAL', 'PENDIENTE'],
                                    ['ESTATUS_COTIZACION','<>' ,'NO'],
                                ])->get(),
                ]);

            });

        })->download('xlsx');

    }

}
