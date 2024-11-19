<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordinadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('coordinadores', function (Blueprint $table) {
            $table->increments('ID_COORDINADOR');
            $table->string('NOMBRE', 50)->charset('utf8');
            $table->string('TELEFONO', 30)->charset('utf8');
            $table->string('CORREO', 50)->charset('utf8');
            $table->boolean('VALIDACION')->default(false);
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordinadores');
    }
}
