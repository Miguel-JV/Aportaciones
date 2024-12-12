<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\encargados_casas;



class EncargadosCasasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('encargados_casas')->insert(['ID_ENCARGADOS_CASAS' => 1,  'ID_ENCARGADO' => 1, 'ID_CASA' => 1]);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/encargados_casas.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                encargados_casas::create([

                    "ID_ENCARGADOS_CASAS" => $data['0'],

                    "ID_ENCARGADO" => $data['1'],
                    "ID_CASA" => $data['2'],
                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
