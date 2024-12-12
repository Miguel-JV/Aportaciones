<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\elementos_objetos;



class ElementosObjetosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('elementos_objetos')->insert(['ID_ELEMENTO_OBJ' => 1,  'ID_OBJETO' => 1, 'NOMBRE' => 'Unidad Interior']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/elementos_obj.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                elementos_objetos::create([

                    "ID_ELEMENTO_OBJ" => $data['0'],
                    "ID_OBJETO" => $data['1'],

                    "NOMBRE" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
