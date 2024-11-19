<?php

namespace App\Exports;

use App\tickets;
use DB;

use Carbon\Carbon;

use Maatwebsite\Excel\Facades\Excel;


class consultaCompuestaTickets {

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
            'pagados'       => $coleccion->where('CASA', $casa)->where('ESTATUS_PAGO', 'SI')->count(),
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

    public function descargar(){
    //GENERAL
        return Excel::create('Consulta de Mantenimientos', function($excel)  {

            $excel->sheet('Resumen', function($sheet)  {
                $historicDateStart = Carbon::now()->startOfYear();
                // $this->dateStart = Carbon::now()->startOfMonth();
                // $this->dateEnd = Carbon::now();

                $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];


                $pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

                $colecciones = [
                    'pendientes' => $pendientes,
                    'procesados' => $procesados,
                    'finalizados' => $finalizados,
                ];


                $pendientes_data = [
                    'aldea'     => self::resumenSitio($pendientes, 'Aldea Iztapalapa'),

                    'campeche'  => self::resumenSitio($pendientes, 'Campeche'),

                    'cuautla'   => self::resumenSitio($pendientes, 'Cuautla'),

                    'culiacan'  => self::resumenSitio($pendientes, 'Culiacán'),

                    'saltillo'  => self::resumenSitio($pendientes, 'Saltillo'),

                    'tapachula' => self::resumenSitio($pendientes, 'Tapachula'),

                    'tuxtla'    => self::resumenSitio($pendientes, 'Tuxtla'),

                    'veracruz'  => self::resumenSitio($pendientes, 'Veracruz'),

                    'sedena'    => self::resumenSitio($pendientes, 'Sedena'),

                    'semar'     => self::resumenSitio($pendientes, 'Semar'),
                ];

                $procesados_data = [
                    'aldea'     => self::resumenSitio($procesados, 'Aldea Iztapalapa'),

                    'campeche'  => self::resumenSitio($procesados, 'Campeche'),

                    'cuautla'   => self::resumenSitio($procesados, 'Cuautla'),

                    'culiacan'  => self::resumenSitio($procesados, 'Culiacán'),

                    'saltillo'  => self::resumenSitio($procesados, 'Saltillo'),

                    'tapachula' => self::resumenSitio($procesados, 'Tapachula'),

                    'tuxtla'    => self::resumenSitio($procesados, 'Tuxtla'),

                    'veracruz'  => self::resumenSitio($procesados, 'Veracruz'),

                    'sedena'    => self::resumenSitio($procesados, 'Sedena'),

                    'semar'     => self::resumenSitio($procesados, 'Semar'),
                ];

                $finalizados_data = [
                    'aldea'     => self::resumenSitio($finalizados, 'Aldea Iztapalapa'),

                    'campeche'  => self::resumenSitio($finalizados, 'Campeche'),

                    'cuautla'   => self::resumenSitio($finalizados, 'Cuautla'),

                    'culiacan'  => self::resumenSitio($finalizados, 'Culiacán'),

                    'saltillo'  => self::resumenSitio($finalizados, 'Saltillo'),

                    'tapachula' => self::resumenSitio($finalizados, 'Tapachula'),

                    'tuxtla'    => self::resumenSitio($finalizados, 'Tuxtla'),

                    'veracruz'  => self::resumenSitio($finalizados, 'Veracruz'),

                    'sedena'    => self::resumenSitio($finalizados, 'Sedena'),

                    'semar'     => self::resumenSitio($finalizados, 'Semar'),
                ];

                $acumulados_data = [
                    'historico' => [
                        'aldea'     => self::acumuladosSitio('historico', 'Aldea Iztapalapa', $colecciones, $historicDateStart, $this->dateEnd),

                        'campeche'  => self::acumuladosSitio('historico', 'Campeche', $colecciones, $historicDateStart, $this->dateEnd),

                        'cuautla'   => self::acumuladosSitio('historico', 'Cuautla', $colecciones, $historicDateStart, $this->dateEnd),

                        'culiacan'  => self::acumuladosSitio('historico', 'Culiacán', $colecciones, $historicDateStart, $this->dateEnd),

                        'saltillo'  => self::acumuladosSitio('historico', 'Saltillo', $colecciones, $historicDateStart, $this->dateEnd),

                        'tapachula' => self::acumuladosSitio('historico', 'Tapachula', $colecciones, $historicDateStart, $this->dateEnd),

                        'tuxtla'    => self::acumuladosSitio('historico', 'Tuxtla', $colecciones, $historicDateStart, $this->dateEnd),

                        'veracruz'  => self::acumuladosSitio('historico', 'Veracruz', $colecciones, $historicDateStart, $this->dateEnd),

                        'sedena'    => self::acumuladosSitio('historico', 'Sedena', $colecciones, $historicDateStart, $this->dateEnd),

                        'semar'     => self::acumuladosSitio('historico', 'Semar', $colecciones, $historicDateStart, $this->dateEnd),
                    ],
                    'monto' => [
                        'aldea'     => self::acumuladosSitio('monto', 'Aldea Iztapalapa', $colecciones, $historicDateStart, $this->dateEnd),

                        'campeche'  => self::acumuladosSitio('monto', 'Campeche', $colecciones, $historicDateStart, $this->dateEnd),

                        'cuautla'   => self::acumuladosSitio('monto', 'Cuautla', $colecciones, $historicDateStart, $this->dateEnd),

                        'culiacan'  => self::acumuladosSitio('monto', 'Culiacán', $colecciones, $historicDateStart, $this->dateEnd),

                        'saltillo'  => self::acumuladosSitio('monto', 'Saltillo', $colecciones, $historicDateStart, $this->dateEnd),

                        'tapachula' => self::acumuladosSitio('monto', 'Tapachula', $colecciones, $historicDateStart, $this->dateEnd),

                        'tuxtla'    => self::acumuladosSitio('monto', 'Tuxtla', $colecciones, $historicDateStart, $this->dateEnd),

                        'veracruz'  => self::acumuladosSitio('monto', 'Veracruz', $colecciones, $historicDateStart, $this->dateEnd),

                        'sedena'    => self::acumuladosSitio('monto', 'Sedena', $colecciones, $historicDateStart, $this->dateEnd),

                        'semar'     => self::acumuladosSitio('monto', 'Semar', $colecciones, $historicDateStart, $this->dateEnd),
                    ],

                ];


                $totales_data = [
                    'pendientes' => [
                        'cantidad'      => $pendientes->count(),
                        'cotizados'     => $pendientes->where('ESTATUS_COTIZACION', 'SI')->count(),
                        'autorizados'   => $pendientes->where('ESTATUS_AUTORIZACION', 'SI')->count(),
                        'montoTotal'    => $pendientes->sum('COTIZACION'),
                    ],
                    'procesados' => [
                        'cantidad'      => $procesados->count(),
                    ],

                    'finalizados' => [
                        'cantidad'      => $finalizados->count(),
                        'pagados'       => $finalizados->where('ESTATUS_PAGO', 'SI')->count(),
                        'montoTotal'    => $finalizados->sum('COTIZACION'),
                    ],

                    'acumulados' => [
                        'historico'     => array_sum($acumulados_data['historico']),
                        'monto'         => array_sum($acumulados_data['monto']),
                    ]
                ];

                // $sheet->setStyle(array(
                //     'font' => array(
                //         'name'      =>  'Calibri',
                //         'size'      =>  9,
                //         'bold'      =>  false
                //     )
                // ));

                $sheet->loadView('exports.ticketResumenGeneral', [
                    'pendientes_data'   => $pendientes_data,
                    'procesados_data'   => $procesados_data,
                    'finalizados_data'  => $finalizados_data,
                    'acumulados_data'   => $acumulados_data,
                    'totales_data'      => $totales_data,
                    'mesCorte'          => $mesCorte,
                    'mesAcumulado'      => $mesAcumulado,
                ]);

                // AJUSTAR AL CONTENIDO
                $sheet->getStyle('A1:K13' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);

                // $sheet->getStyle('A1:K13')->getAlignment()->setWrapText(true);



            });

            $excel->sheet('Estatus Detalle', function($sheet)  {
                $tickets_pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

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

            $excel->sheet('Detalle General', function($sheet)  {

                $sheet->loadView('exports.tickets', [
                    'tickets' => tickets::query()->whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->get()
                ]);

            });

            $excel->sheet('Resumen Sedena', function($sheet)  {
                $historicDateStart = Carbon::now()->startOfYear();

                $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];

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

            $excel->sheet('Resumen Semar', function($sheet)  {
                $historicDateStart = Carbon::now()->startOfYear();

                $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];

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

    public function descargarSedena(){

        return Excel::create('Consulta de Mantenimientos Sedena', function($excel)  {


            $excel->sheet('Resumen Sedena', function($sheet)  {
                $historicDateStart = Carbon::now()->startOfYear();

                $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];

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

    public function descargarSemar(){

        return Excel::create('Consulta de Mantenimientos Semar', function($excel)  {

            $excel->sheet('Resumen Semar', function($sheet)  {
                $historicDateStart = Carbon::now()->startOfYear();

                $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];

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

    public function storeGeneral(){
        //GENERAL
            return Excel::create('Reporte_Mantenimientos_General', function($excel)  {

                $excel->sheet('Resumen', function($sheet)  {
                    $historicDateStart = Carbon::now()->startOfYear();
                    // $this->dateStart = Carbon::now()->startOfMonth();
                    // $this->dateEnd = Carbon::now();

                    $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                    $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                    $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];


                    $pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                    $procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                    $finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

                    $colecciones = [
                        'pendientes' => $pendientes,
                        'procesados' => $procesados,
                        'finalizados' => $finalizados,
                    ];


                    $pendientes_data = [
                        'aldea'     => self::resumenSitio($pendientes, 'Aldea Iztapalapa'),

                        'campeche'  => self::resumenSitio($pendientes, 'Campeche'),

                        'cuautla'   => self::resumenSitio($pendientes, 'Cuautla'),

                        'culiacan'  => self::resumenSitio($pendientes, 'Culiacán'),

                        'saltillo'  => self::resumenSitio($pendientes, 'Saltillo'),

                        'tapachula' => self::resumenSitio($pendientes, 'Tapachula'),

                        'tuxtla'    => self::resumenSitio($pendientes, 'Tuxtla'),

                        'veracruz'  => self::resumenSitio($pendientes, 'Veracruz'),

                        'sedena'    => self::resumenSitio($pendientes, 'Sedena'),

                        'semar'     => self::resumenSitio($pendientes, 'Semar'),
                    ];

                    $procesados_data = [
                        'aldea'     => self::resumenSitio($procesados, 'Aldea Iztapalapa'),

                        'campeche'  => self::resumenSitio($procesados, 'Campeche'),

                        'cuautla'   => self::resumenSitio($procesados, 'Cuautla'),

                        'culiacan'  => self::resumenSitio($procesados, 'Culiacán'),

                        'saltillo'  => self::resumenSitio($procesados, 'Saltillo'),

                        'tapachula' => self::resumenSitio($procesados, 'Tapachula'),

                        'tuxtla'    => self::resumenSitio($procesados, 'Tuxtla'),

                        'veracruz'  => self::resumenSitio($procesados, 'Veracruz'),

                        'sedena'    => self::resumenSitio($procesados, 'Sedena'),

                        'semar'     => self::resumenSitio($procesados, 'Semar'),
                    ];

                    $finalizados_data = [
                        'aldea'     => self::resumenSitio($finalizados, 'Aldea Iztapalapa'),

                        'campeche'  => self::resumenSitio($finalizados, 'Campeche'),

                        'cuautla'   => self::resumenSitio($finalizados, 'Cuautla'),

                        'culiacan'  => self::resumenSitio($finalizados, 'Culiacán'),

                        'saltillo'  => self::resumenSitio($finalizados, 'Saltillo'),

                        'tapachula' => self::resumenSitio($finalizados, 'Tapachula'),

                        'tuxtla'    => self::resumenSitio($finalizados, 'Tuxtla'),

                        'veracruz'  => self::resumenSitio($finalizados, 'Veracruz'),

                        'sedena'    => self::resumenSitio($finalizados, 'Sedena'),

                        'semar'     => self::resumenSitio($finalizados, 'Semar'),
                    ];

                    $acumulados_data = [
                        'historico' => [
                            'aldea'     => self::acumuladosSitio('historico', 'Aldea Iztapalapa', $colecciones, $historicDateStart, $this->dateEnd),

                            'campeche'  => self::acumuladosSitio('historico', 'Campeche', $colecciones, $historicDateStart, $this->dateEnd),

                            'cuautla'   => self::acumuladosSitio('historico', 'Cuautla', $colecciones, $historicDateStart, $this->dateEnd),

                            'culiacan'  => self::acumuladosSitio('historico', 'Culiacán', $colecciones, $historicDateStart, $this->dateEnd),

                            'saltillo'  => self::acumuladosSitio('historico', 'Saltillo', $colecciones, $historicDateStart, $this->dateEnd),

                            'tapachula' => self::acumuladosSitio('historico', 'Tapachula', $colecciones, $historicDateStart, $this->dateEnd),

                            'tuxtla'    => self::acumuladosSitio('historico', 'Tuxtla', $colecciones, $historicDateStart, $this->dateEnd),

                            'veracruz'  => self::acumuladosSitio('historico', 'Veracruz', $colecciones, $historicDateStart, $this->dateEnd),

                            'sedena'    => self::acumuladosSitio('historico', 'Sedena', $colecciones, $historicDateStart, $this->dateEnd),

                            'semar'     => self::acumuladosSitio('historico', 'Semar', $colecciones, $historicDateStart, $this->dateEnd),
                        ],
                        'monto' => [
                            'aldea'     => self::acumuladosSitio('monto', 'Aldea Iztapalapa', $colecciones, $historicDateStart, $this->dateEnd),

                            'campeche'  => self::acumuladosSitio('monto', 'Campeche', $colecciones, $historicDateStart, $this->dateEnd),

                            'cuautla'   => self::acumuladosSitio('monto', 'Cuautla', $colecciones, $historicDateStart, $this->dateEnd),

                            'culiacan'  => self::acumuladosSitio('monto', 'Culiacán', $colecciones, $historicDateStart, $this->dateEnd),

                            'saltillo'  => self::acumuladosSitio('monto', 'Saltillo', $colecciones, $historicDateStart, $this->dateEnd),

                            'tapachula' => self::acumuladosSitio('monto', 'Tapachula', $colecciones, $historicDateStart, $this->dateEnd),

                            'tuxtla'    => self::acumuladosSitio('monto', 'Tuxtla', $colecciones, $historicDateStart, $this->dateEnd),

                            'veracruz'  => self::acumuladosSitio('monto', 'Veracruz', $colecciones, $historicDateStart, $this->dateEnd),

                            'sedena'    => self::acumuladosSitio('monto', 'Sedena', $colecciones, $historicDateStart, $this->dateEnd),

                            'semar'     => self::acumuladosSitio('monto', 'Semar', $colecciones, $historicDateStart, $this->dateEnd),
                        ],

                    ];


                    $totales_data = [
                        'pendientes' => [
                            'cantidad'      => $pendientes->count(),
                            'cotizados'     => $pendientes->where('ESTATUS_COTIZACION', 'SI')->count(),
                            'autorizados'   => $pendientes->where('ESTATUS_AUTORIZACION', 'SI')->count(),
                            'montoTotal'    => $pendientes->sum('COTIZACION'),
                        ],
                        'procesados' => [
                            'cantidad'      => $procesados->count(),
                        ],

                        'finalizados' => [
                            'cantidad'      => $finalizados->count(),
                            'pagados'       => $finalizados->where('ESTATUS_PAGO', 'SI')->count(),
                            'montoTotal'    => $finalizados->sum('COTIZACION'),
                        ],

                        'acumulados' => [
                            'historico'     => array_sum($acumulados_data['historico']),
                            'monto'         => array_sum($acumulados_data['monto']),
                        ]
                    ];

                    // $sheet->setStyle(array(
                    //     'font' => array(
                    //         'name'      =>  'Calibri',
                    //         'size'      =>  9,
                    //         'bold'      =>  false
                    //     )
                    // ));

                    $sheet->loadView('exports.ticketResumenGeneral', [
                        'pendientes_data'   => $pendientes_data,
                        'procesados_data'   => $procesados_data,
                        'finalizados_data'  => $finalizados_data,
                        'acumulados_data'   => $acumulados_data,
                        'totales_data'      => $totales_data,
                        'mesCorte'          => $mesCorte,
                        'mesAcumulado'      => $mesAcumulado,
                    ]);

                    // AJUSTAR AL CONTENIDO
                    $sheet->getStyle('A1:K13' , $sheet->getHighestRow())->getAlignment()->setWrapText(true);

                    // $sheet->getStyle('A1:K13')->getAlignment()->setWrapText(true);



                });

                $excel->sheet('Estatus Detalle', function($sheet)  {
                    $tickets_pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                    $tickets_procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                    $tickets_finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

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

                $excel->sheet('Detalle General', function($sheet)  {

                    $sheet->loadView('exports.tickets', [
                        'tickets' => tickets::query()->whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->get()
                    ]);

                });

            })->store('xlsx', storage_path('app/public/tickets/reportes'));

    }

    public function storeSedena(){
        //GENERAL
            return Excel::create('Reporte_Mantenimientos_Sedena', function($excel)  {

                $excel->sheet('Resumen Sedena', function($sheet)  {
                    $historicDateStart = Carbon::now()->startOfYear();

                    $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                    $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                    $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];

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

            })->store('xlsx', storage_path('app/public/tickets/reportes'));

    }

    public function storeSemar(){
        //GENERAL
            return Excel::create('Reporte_Mantenimientos_Semar', function($excel)  {

                $excel->sheet('Resumen Semar', function($sheet)  {
                    $historicDateStart = Carbon::now()->startOfYear();

                    $meses = array("ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");
                    $mesAcumulado = $meses[($historicDateStart->format('n')) - 1];
                    $mesCorte = $meses[(date("n",strtotime($this->dateEnd))) - 2];

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

            })->store('xlsx', storage_path('app/public/tickets/reportes'));

    }


    public function onUnknownSheet($sheetName){
        // Mostrar pagina no econtrada
        info("Pagina {$sheetName} omitida.");
    }


}
