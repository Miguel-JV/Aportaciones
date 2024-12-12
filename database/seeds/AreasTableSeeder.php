<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\areas;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('areas')->insert(['ID_AREA' => 1,  'NOMBRE' => 'Alcaldía']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/areas.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                areas::create([

                    "ID_AREA" => $data['0'],

                    "NOMBRE" => $data['1'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
