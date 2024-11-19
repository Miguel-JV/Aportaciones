<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\coordinadores_casas;

class CoordinadoresCasasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coordinadores_casas')->insert(['ID_COORDINADORES_CASAS' => 1,  'ID_COORDINADOR' => 1, 'ID_CASA' => 1]);


        $csvFile = fopen(storage_path("app/archivos/registrosTickets/coordinadores_casas.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                coordinadores_casas::create([

                    "ID_COORDINADORES_CASAS" => $data['0'],

                    "ID_COORDINADOR" => $data['1'],
                    "ID_CASA" => $data['2'],
                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
