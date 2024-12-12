<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\afecciones;


class AfeccionesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('afecciones')->insert(['ID_AFECCION' => 1,  'ID_AREA' => 6, 'NOMBRE' => 'Alarma']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/afecciones.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                afecciones::create([

                    "ID_AFECCION" => $data['0'],
                    "ID_AREA" => $data['1'],

                    "NOMBRE" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }

}
