<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\espacios;



class EspaciosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('espacios')->insert(['ID_ESPACIO' => 1,  'ID_SITIO' => 34, 'NOMBRE' => 'Puerta de Acceso']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/espacios.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                espacios::create([

                    "ID_ESPACIO" => $data['0'],
                    "ID_SITIO" => $data['1'],

                    "NOMBRE" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
