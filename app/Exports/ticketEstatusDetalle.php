<?php

namespace App\Exports;

use App\tickets;

use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;


class ticketEstatusDetalle {

    /**
    * @return \Illuminate\Support\Collection
    */


    public function __construct($dateStart, $dateEnd){
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }


    public function styles(Worksheet $sheet){
        return [

            'A' => ['font' => ['size' => 8]],

            'B' => ['font' => ['size' => 8]],

            'C' => ['font' => ['size' => 8]],

            'D' => ['font' => ['size' => 8]],

            'E' => ['font' => ['size' => 8]],

            'F' => ['font' => ['size' => 8]],

            'G' => ['font' => ['size' => 8]],

            'H' => ['font' => ['size' => 8]],

        ];
    }

    public function descargar(){

        return Excel::create('Consulta de Mantenimientos', function($excel)  {

            $excel->sheet('Estatus Detalle', function($sheet)  {
                $tickets_pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
                $tickets_finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

                $resultado = [
                    'pendientes' => $tickets_pendientes,
                    'procesados' => $tickets_procesados,
                    'finalizados' => $tickets_finalizados,
                ];

                // $sheet->setAutoSize(true);

                // $sheet->setWidth(array(
                //     'A'     =>  500,
                //     'B'     =>  100
                // ));

                $sheet->loadView('exports.ticketEstatusDetalle', [
                    'resultado' => $resultado
                ]);

                // $sheet->setAutoSize(array(
                //     'A', 'B', 'C' , 'D'
                // ));


            });


        })->download('xlsx');

    }

    public function view(): View{

        $tickets_pendientes = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'PENDIENTE')->orderBy('ESTATUS_CASA', 'ASC')->get();
        $tickets_procesados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'EN PROCESO')->orderBy('ESTATUS_CASA', 'ASC')->get();
        $tickets_finalizados = tickets::whereBetween('FECHA_INICIO', [$this->dateStart,$this->dateEnd])->where('ESTATUS_ACTUAL', 'FINALIZADO')->orderBy('ESTATUS_CASA', 'ASC')->get();

        $resultado = [
            'pendientes' => $tickets_pendientes,
            'procesados' => $tickets_procesados,
            'finalizados' => $tickets_finalizados,
        ];
        return view('exports.ticketEstatusDetalle', [
            'resultado' => $resultado
        ]);
    }
    }
