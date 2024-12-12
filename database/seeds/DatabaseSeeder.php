<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

        $this->call(CasasTableSeeder::class);
        $this->call(DrivesTableSeeder::class);
        $this->call(DirectoresTableSeeder::class);
        $this->call(AreasTableSeeder::class);
        $this->call(AfeccionesTableSeeder::class);
        $this->call(EncargadosTableSeeder::class);
        $this->call(EncargadosCasasTableSeeder::class);
        $this->call(PrioridadesTableSeeder::class);
        $this->call(TiposDanosTableSeeder::class);
        $this->call(EntornosTableSeeder::class);
        $this->call(SitiosTableSeeder::class);
        $this->call(ObjetosTableSeeder::class);
        $this->call(ElementosObjetosTableSeeder::class);
        $this->call(EspaciosTableSeeder::class);
        $this->call(CoordinadoresTableSeeder::class);
        $this->call(CoordinadoresCasasTableSeeder::class);
        $this->call(TicketsTableSeeder::class);

    }
}
