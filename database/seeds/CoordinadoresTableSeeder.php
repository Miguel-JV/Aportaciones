<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\coordinadores;
use Illuminate\Support\Facades\Hash;

class CoordinadoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('coordinadores')->insert(['ID_COORDINADOR' => 1,  'NOMBRE' =>'Jorge Leybón', 'TELEFONO' => '(+52)5527294121', 'CORREO' => 'reportes.bdt@gmail.com', 'VALIDACION' => false]);


        $csvFile = fopen(storage_path("app/archivos/registrosTickets/coordinadores.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                coordinadores::create([

                    "ID_COORDINADOR" => $data['0'],

                    "NOMBRE"         => $data['1'],
                    "TELEGRAM"       => $data['2'],
                    "CORREO"         => $data['3'],
                    "VALIDACION"     => $data['4'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}

