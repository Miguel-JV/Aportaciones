<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\sitios;



class SitiosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('sitios')->insert(['ID_SITIO' => 1,  'ID_ENTORNO' => 1, 'SITIO' => 'Aliados_tecnológicos']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/sitios.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                sitios::create([

                    "ID_SITIO" => $data['0'],
                    "ID_ENTORNO" => $data['1'],

                    "SITIO" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
