<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDirectoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('directores', function (Blueprint $table) {
            $table->increments('ID_DIRECTOR');
            $table->integer('ID_CASA')->nullable(false)->unsigned();

            $table->string('NOMBRE', 100)->charset('utf8');
            $table->string('CORREO', 100)->charset('utf8');
            // $table->timestamps();
        });

        Schema::table('directores', function ($table) {
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
        Schema::dropIfExists('directores');
    }
}
