<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTask extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
			Schema::create('tasks', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombre');/*Tipo de actividad*/
			$table->text('descripcion')->nullable();/*Descripcion de la actividad*/
			$table->date('fecha_inicio');/*Fechas*/
			$table->date('fecha_fin');/*Fechas*/
			$table->string('Color');/*Color del evento 	backgroundColor o borderColor "#f56954" */
			$table->boolean('allDay');/*AllDay*/
			$table->string('url');
			$table->rememberToken();
			$table->timestamps();
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
		Schema::drop('tasks');
	}

}
