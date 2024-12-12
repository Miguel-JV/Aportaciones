<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\encargados;


class EncargadosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('encargados')->insert(['ID_ENCARGADO' => 1,  'ID_AREA' => 2, 'NOMBRE' => 'Héctor Hugo González Pérez',    'PUESTO' => 'GERENTE', 'CORREO' => 'HGPEREZ@gta-mex.com']);


        $csvFile = fopen(storage_path("app/archivos/registrosTickets/encargados.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                encargados::create([

                    "ID_ENCARGADO" => $data['0'],
                    "ID_AREA" => $data['1'],

                    "NOMBRE" => $data['2'],
                    "PUESTO" => $data['3'],
                    "CORREO" => $data['4']
                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);

    }
}
