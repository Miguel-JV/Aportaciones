<?php

namespace App\Exports;

use App\tickets;
use DB;

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;


class consultaCompuestaSedena {

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

    public function descargarSedena(){

        return Excel::create('Consulta de Mantenimientos Sedena', function($excel)  {


            $excel->sheet('Resumen Sedena', function($sheet)  {
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

                    'sedena'    => self::resumenSitio($pendientes, 'Sedena'),
                ];

                $procesados_data = [
                    'sedena'    => self::resumenSitio($procesados, 'Sedena'),
                ];

                $finalizados_data = [
                    'sedena'    => self::resumenSitio($finalizados, 'Sedena'),
                ];

                $acumulados_data = [
                    'historico' => [
                        'sedena'    => self::acumuladosSitio('historico', 'Sedena', $colecciones, $historicDateStart, $this->dateEnd),
                    ],
                    'monto' => [

                        'sedena'    => self::acumuladosSitio('monto', 'Sedena', $colecciones, $historicDateStart, $this->dateEnd),
                    ],

                ];


                $totales_data = [
                    'pendientes' => [
                        'cantidad'      => $pendientes->where('CASA', 'Sedena')->count(),
                        'autorizados'   => $pendientes->where('CASA', 'Sedena')->where('ESTATUS_AUTORIZACION', 'SI')->count(),
                        'cotizados'     => $pendientes->where('CASA', 'Sedena')->where('ESTATUS_COTIZACION', 'SI')->count(),

                    ],
                    'procesados' => [
                        'cantidad'      => $procesados->where('CASA', 'Sedena')->count(),
                    ],

                    'finalizados' => [
                        'cantidad'      => $finalizados->where('CASA', 'Sedena')->count(),
                        'pagados'       => $finalizados->where('CASA', 'Sedena')->where('ESTATUS_PAGO', 'SI')->count(),
                    ],

                    'acumulados' => [
                        'historico'     => array_sum($acumulados_data['historico']),
                    ]
                ];


                $sheet->loadView('exports.ticketResumenSdn', [
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

            $excel->sheet('Estatus Detalle Sedena', function($sheet)  {
                $tickets_pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('CASA', 'Sedena')->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('CASA', 'Sedena')->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('CASA', 'Sedena')->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

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
