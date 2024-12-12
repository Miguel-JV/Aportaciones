<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\tipos_danos;


class TiposDanosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('tipos_danos')->insert(['ID_TIPO_DANO' => 1,  'ID_PRIORIDAD' => 1, 'DETALLE' => 'Siniestro - Temblor']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/tipos_daños.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                tipos_danos::create([

                    "ID_TIPO_DANO" => $data['0'],
                    "ID_PRIORIDAD" => $data['1'],

                    "DETALLE" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
