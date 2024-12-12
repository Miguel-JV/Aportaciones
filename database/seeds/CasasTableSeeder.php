<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\casas;

class CasasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('casas')->insert([
        //     'ID_CASA' => 1,
        //     'NOMBRE' => 'Aldea Iztapalapa',
        //     'ESTATUS' => 'ABIERTA',
        //     'CORREO' => ''
        //     ]);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/casas.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                casas::create([

                    "ID_CASA" => $data['0'],

                    "NOMBRE" => $data['1'],
                    "ESTATUS" => $data['2'],
                    "CORREO" => $data['3'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
