<?php

namespace App\Exports;

use App\tickets;

use Maatwebsite\Excel\Facades\Excel;

class ticketsExport {

    /**
    * @return \Illuminate\Support\Collection
    */
    // use Exportable;

    public function __construct($dateStart, $dateEnd){
        $this->dateStart = $dateStart;
        $this->dateEnd = $dateEnd;
    }

    public function descargar(){

        return Excel::create('Consulta de Mantenimientos', function($excel)  {

            $excel->sheet('Detalle General', function($sheet)  {

                $sheet->loadView('exports.tickets', [
                    'tickets' => tickets::query()->whereBetween('FECHA_INICIO', [$this->dateStart, $this->dateEnd])->get()
                ]);

            });


        })->download('xlsx');

    }

}
