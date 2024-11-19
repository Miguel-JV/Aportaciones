<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinadoresCasasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordinadores_casas', function (Blueprint $table) {
            $table->increments('ID_COORDINADORES_CASAS');
            $table->integer('ID_COORDINADOR')->nullable(false)->unsigned();
            $table->integer('ID_CASA')->nullable(false)->unsigned();

            // $table->timestamps();
        });

        Schema::table('coordinadores_casas', function ($table) {
            $table->foreign('ID_COORDINADOR')
                ->references('ID_COORDINADOR')->on('coordinadores')
                ->onDelete('cascade');

            $table->foreign('ID_CASA')
                ->references('ID_CASA')->on('casas')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinadores_casas');
    }
}
