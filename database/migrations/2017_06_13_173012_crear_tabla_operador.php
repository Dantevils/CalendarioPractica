<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOperador extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operador', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('rut')->nullable();
            $table->string('direccion')->nullable();
            $table->string('contacto')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('url')->nullable();
            $table->integer('tipo')->nullable(); // la tabla parametro_grupo  en diseño antiguo
            $table->integer('comuna_id')->unsigned()->nullable();

            $table->string('gcalendar_id');//ID de google calendar a guardar
            $table->string('ocalendar_id');//ID de Outlook calendar a guardar
            //$table->foreign('comuna_id')->references('id')->on('comuna');

            
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
        Schema::dropIfExists('operador');
    }
}
