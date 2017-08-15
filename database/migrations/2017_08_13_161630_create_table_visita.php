<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVisita extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 Schema::create('Visita', function (Blueprint $table) {

            $table->string('id')->index();
            $table->string('respaldo');
            $table->string('estacion_id');
            $table->string('personal_id');
            $table->date('fecha');
            $table->date('hora_inicio');
            $table->string('estado_inicial_id');
            $table->string('temperatura_inicio');
            $table->string('motivo_visita');
            $table->string('tiempo_id');
            $table->string('observacion');
            $table->date('hora_termino');
            $table->date('fecha_prox_visita');
            $table->string('plantilla');
            $table->string('plantilla_nombre');
            $table->string('listado_id');
            $table->string('listado_url');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		   Schema::drop('Visita');
	}

}
