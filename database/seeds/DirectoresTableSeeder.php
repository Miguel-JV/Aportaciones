<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\directores;
use Illuminate\Support\Facades\Hash;
class DirectoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('directores')->insert(['ID_DIRECTOR' => 1,  'ID_CASA' => 1, 'NOMBRE' => 'Gabriel Reyes Betanzos', 'CORREO' => 'gabriel.reyes@telmexeducacion.com']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/directores.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                directores::create([

                    "ID_DIRECTOR"   => $data['0'],
                    "ID_CASA"       => $data['1'],

                    "NOMBRE"        => $data['2'],
                    "CORREO"        => $data['3'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
