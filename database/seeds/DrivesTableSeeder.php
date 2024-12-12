<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\drives;


class DrivesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('drives')->insert(['ID_DRIVE' => 1,  'ID_CASA' => 1, 'LIGA' => 'https://drive.google.com/drive/folders/1ooG_cYUvjzEfAVSkKlqK3MoDcZJM_eWL']);

        $csvFile = fopen(storage_path("app/archivos/registrosTickets/drives.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                drives::create([

                    "ID_DRIVE" => $data['0'],
                    "ID_CASA" => $data['1'],

                    "LIGA" => $data['2'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
