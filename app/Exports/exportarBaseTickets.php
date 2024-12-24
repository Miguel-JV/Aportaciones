<?php

namespace App\Exports;

use App\tickets;
use DB;


use Maatwebsite\Excel\Facades\Excel;


class exportarBaseTickets {

    /**
    * @return \Illuminate\Support\Collection
    */
    // use WithConditionalSheets;

    public function __construct(){

    }



    public function descargar(){
    //GENERAL
        return Excel::create('Base Completa Tickets', function($excel)  {

            $excel->sheet('Detalle General', function($sheet)  {

                $sheet->loadView('exports.tickets', [

                    'tickets' => tickets::all(),
                ]);

            });

        })->download('xlsx');

    }

}
