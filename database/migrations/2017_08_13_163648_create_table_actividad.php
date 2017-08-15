<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableActividad extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		 Schema::create('Actividads', function (Blueprint $table) {

            $table->string('id')->index();
            $table->string('actividad_estado_id');
            $table->string('equipo_id');
            $table->string('ejecucion');
            $table->date('actividad_tipo_id');
            $table->date('automatica');
            $table->string('obsercacion');
            $table->string('operador_id');
            $table->string('agenda_id');
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
		Schema::drop('Actividad');
	}

}
