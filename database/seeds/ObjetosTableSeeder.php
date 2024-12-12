<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\objetos;



class ObjetosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('objetos')->insert(['ID_OBJETO' => 1,  'ID_ENTORNO' => 1, 'NOMBRE' => 'Aire_Acondicionado']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/objetos.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                objetos::create([

                    "ID_OBJETO" => $data['0'],
                    "ID_ENTORNO" => $data['1'],

                    "NOMBRE" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
