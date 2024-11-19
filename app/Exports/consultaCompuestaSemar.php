<?php

namespace App\Exports;

use App\tickets;
use DB;

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;


class consultaCompuestaSemar {

    /**
    * @return \Illuminate\Support\Collection
    */
    // use WithConditionalSheets;

    public function __construct($dateStart, $dateEnd){
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    // METODOS DE CONSULTA
    public function resumenSitio($coleccion, $casa) {
        $data = [
            'cantidad'      => $coleccion->where('CASA', $casa)->count(),
            'cotizados'     => $coleccion->where('CASA', $casa)->where('ESTATUS_COTIZACION', 'SI')->count(),
            'autorizados'   => $coleccion->where('CASA', $casa)->where('ESTATUS_AUTORIZACION', 'SI')->count(),
            'montoTotal'    => $coleccion->where('CASA', $casa)->sum('COTIZACION'),
            'pagados'       => $coleccion->where('CASA', $casa)->where('ESTATUS_PAGO, SI')->count(),
        ];

        return $data;
    }

    public function acumuladosSitio($historico_monto, $casa, $colecciones, $historicDateStart, $dateEnd){
        switch ($historico_monto) {
            case 'historico':
                return tickets::whereBetween('FECHA_INICIO', [$historicDateStart, $dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->where('CASA', $casa)->count() - $colecciones['finalizados']->where('CASA', $casa)->count();
                break;

            case 'monto':
                return tickets::whereBetween('FECHA_INICIO', [$historicDateStart, $dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->where('CASA', $casa)->sum('COTIZACION') -  $colecciones['finalizados']->where('CASA', $casa)->sum('COTIZACION');
            break;

            default:
                return 'ERROR DE REGISTRO';
                break;
        }
    }

    public function descargarSemar(){

        return Excel::create('Consulta de Mantenimientos Semar', function($excel)  {

            $excel->sheet('Resumen Semar', function($sheet)  {
                $historicDateStart = Carbon::now()->startOfYear();

                $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                $mesCorte = $meses[(date("n",strtotime($this->dateStart))) - 2];

                $pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

                $colecciones = [
                    'pendientes' => $pendientes,
                    'procesados' => $procesados,
                    'finalizados' => $finalizados,
                ];


                $pendientes_data = [

                    'semar'     => self::resumenSitio($pendientes, 'Semar'),
                ];

                $procesados_data = [
                    'semar'     => self::resumenSitio($procesados, 'Semar'),
                ];

                $finalizados_data = [
                    'semar'     => self::resumenSitio($finalizados, 'Semar'),
                ];

                $acumulados_data = [
                    'historico' => [
                        'semar'     => self::acumuladosSitio('historico', 'Semar', $colecciones, $historicDateStart, $this->dateEnd),
                    ],
                    'monto' => [

                        'semar'     => self::acumuladosSitio('monto', 'Semar', $colecciones, $historicDateStart, $this->dateEnd),
                    ],

                ];


                $totales_data = [
                    'pendientes' => [
                        'cantidad'      => $pendientes->where('CASA', 'Semar')->count(),
                        'autorizados'   => $pendientes->where('CASA', 'Semar')->where('ESTATUS_AUTORIZACION', 'SI')->count(),
                        'cotizados'     => $pendientes->where('CASA', 'Semar')->where('ESTATUS_COTIZACION', 'SI')->count(),

                    ],
                    'procesados' => [
                        'cantidad'      => $procesados->where('CASA', 'Semar')->count(),
                    ],

                    'finalizados' => [
                        'cantidad'      => $finalizados->where('CASA', 'Semar')->count(),
                        'pagados'       => $finalizados->where('CASA', 'Semar')->where('ESTATUS_PAGO', 'SI')->count(),
                    ],

                    'acumulados' => [
                        'historico'     => array_sum($acumulados_data['historico']),
                    ]
                ];


                $sheet->loadView('exports.ticketResumenSemar', [
                    'pendientes_data'   => $pendientes_data,
                    'procesados_data'   => $procesados_data,
                    'finalizados_data'  => $finalizados_data,
                    'acumulados_data'   => $acumulados_data,
                    'totales_data'      => $totales_data,
                    'mesCorte'          => $mesCorte,
                    'mesAcumulado'      => $mesAcumulado,
                ]);

                // AJUSTAR AL CONTENIDO
                $sheet->getStyle('A1:H5' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);

            });

            $excel->sheet('Estatus Detalle Semar', function($sheet)  {
                $tickets_pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('CASA', 'Semar')->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('CASA', 'Semar')->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('CASA', 'Semar')->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

                $resultado = [
                    'pendientes' => $tickets_pendientes,
                    'procesados' => $tickets_procesados,
                    'finalizados' => $tickets_finalizados,
                ];

                $sheet->loadView('exports.ticketEstatusDetalle', [
                    'resultado' => $resultado
                ]);

                // AJUSTAR AL CONTENIDO
                $sheet->getStyle('A1:G999' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);

            });

        })->download('xlsx');

    }



    public function onUnknownSheet($sheetName){
        // Mostrar pagina no econtrada
        info("Pagina {$sheetName} omitida.");
    }


}
