<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = fopen(storage_path("app/archivos/registrosTickets/users.csv"), "r");
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ",")) !== FALSE) {

            if (!$firstline) {
                User::create([

                    "id"        => $data['0'],
                    "folio"     => $data['1'],
                    "password"  => Hash::make($data['2']),
                    "rol"       => $data['3'],

                    "userable_id"   => $data['4'],
                    "userable_type" => $data['5'],

                ]);

            }
            $firstline = false;

        }

        fclose($csvFile);
    }
}
