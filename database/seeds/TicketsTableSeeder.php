<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\tickets;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/baseTickets.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                tickets::create([

                    'ID_TICKET'         => $data['0'],
                    'ID_CASA'           => $data['1'],
                    'ID_AFECCION'       => $data['2'],
                    'ID_ENTORNO'        => $data['3'],
                    'ID_TIPO_DANO'      => $data['4'],

                    'FOLIO'             => $data['5'],
                    'FECHA_INICIO'      => $data['6'],
                    // 'ESTATUS_ACTUAL'    => $data[''],
                    'CASA'              => $data['7'],
                    'DIRECTOR'          => $data['8'],
                    'AFECCION'          => $data['9'],
                    'AREA_RESPONSABLE'  => $data['10'],
                    'SUPERVISOR'        => $data['11'],
                    'SUBGERENTE'        => $data['12'],
                    'GERENTE'           => $data['13'],

                    'PRIORIDAD'         => $data['14'],
                    'NIVEL'             => $data['15'],

                    'REINCIDENCIA'      => $data['16'],
                    'ENTORNO'           => $data['17'],
                    'SITIO'             => $data['18'],
                    'OBJETO'            => $data['19'],
                    // 'ESPACIO'           => $data[''],
                    'ELEMENTO'          => $data['20'],
                    'DAÑO'              => $data['21'],
                    'DRIVE'             => $data['22'],
                    'DETALLE'           => $data['23'],

                    'FECHA_FIN'         => empty($data['24']) ? null : $data['24'],
                    'AREA_ATENCION'     => $data['25'],
                    'PERSONA_ATENCION'  => $data['26'],
                    'ESTATUS_ACTUAL'    => $data['27'],
                    'OBSERVACIONES'     => $data['28'],
                    'ESTATUS_CASA'      => $data['29'],
                    'ESTATUS_COTIZACION'=> $data['30'],
                    'ESTATUS_AUTORIZACION'=> $data['31'],
                    'ESTATUS_PAGO'      => $data['32'],
                    'COTIZACION'        => $data['33'] == "" ? null : $data['33'],
                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
