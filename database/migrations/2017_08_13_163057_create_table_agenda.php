<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAgenda extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
				//
		 Schema::create('Agenda', function (Blueprint $table) {

            $table->string('id')->index();
            $table->string('fecha')->index();
            $table->string('inicio');
            $table->string('fin')->index();
            $table->date('operacion_id')->index();
            $table->date('estacion_id');
            $table->string('personal_id')->index();

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
		Schema::drop('Agenda');
	}

}
