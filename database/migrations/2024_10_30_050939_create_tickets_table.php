<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->increments('ID_TICKET');
            $table->integer('ID_CASA')->nullable(false)->unsigned();
            $table->integer('ID_AFECCION')->nullable(false)->unsigned();
            $table->integer('ID_ENTORNO')->nullable(false)->unsigned();
            $table->integer('ID_TIPO_DANO')->nullable(false)->unsigned();

            $table->string('FOLIO', 50);
            $table->date('FECHA_INICIO');
            $table->string('CASA', 100);
            $table->string('DIRECTOR', 100);
            $table->string('AFECCION', 100);
            $table->string('AREA_RESPONSABLE', 100);
            $table->string('SUPERVISOR', 100);
            $table->string('SUBGERENTE', 100);
            $table->string('GERENTE', 100);

            $table->string('PRIORIDAD', 50);
            $table->string('NIVEL', 50)->nullable();

            $table->string('REINCIDENCIA', 50);
            $table->string('ENTORNO', 100);
            $table->string('SITIO', 100);
            $table->string('OBJETO', 100)->nullable();
            $table->string('ESPACIO', 100)->nullable();
            $table->string('ELEMENTO', 100)->nullable();
            $table->string('DAÑO', 100);
            $table->string('DRIVE', 100);
            $table->string('DETALLE', 100)->nullable();

            $table->string('FOTO_OBLIGATORIA', 100)->nullable();
            $table->string('FOTO_2', 100)->nullable();
            $table->string('FOTO_3', 100)->nullable();

            $table->string('ARCHIVO_COTIZACION', 100)->nullable();
            $table->string('ARCHIVO_AUTORIZACION', 100)->nullable();

            $table->decimal('COTIZACION', 19, 2)->nullable();
            $table->date('FECHA_COMPROMISO')->nullable();

            $table->string('ESTATUS_CASA', 50)->nullable();
            $table->string('ESTATUS_COTIZACION', 50)->nullable();
            $table->string('ESTATUS_AUTORIZACION', 100)->nullable();
            $table->string('ESTATUS_ACTUAL', 100)->nullable();
            $table->string('ESTATUS_PAGO', 100)->nullable();

            $table->string('EVIDENCIA_PAGO', 100)->nullable();

            $table->date('FECHA_FIN')->nullable();
            $table->string('AREA_ATENCION', 100)->nullable();
            $table->string('PERSONA_ATENCION', 100)->nullable();
            $table->string('OBSERVACIONES', 100)->nullable();
            $table->string('EVIDENCIA', 200)->nullable();


            $table->timestamps();
        });

        Schema::table('tickets', function ($table) {
            $table->foreign('ID_CASA')
                ->references('ID_CASA')->on('casas')
                ->onDelete('cascade');

            $table->foreign('ID_AFECCION')
                ->references('ID_AFECCION')->on('afecciones')
                ->onDelete('cascade');

            $table->foreign('ID_ENTORNO')
                ->references('ID_ENTORNO')->on('entornos')
                ->onDelete('cascade');

            $table->foreign('ID_TIPO_DANO')
                ->references('ID_TIPO_DANO')->on('tipos_danos')
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
        Schema::dropIfExists('tickets');
    }
}
