<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Actividad extends Model {

	//
	  protected $fillable = [
        'id', 'actividad_estado_id', 'equipo_id', 'ejecucion', 'actividad_tipo_id', 'automatica', 'obsercacion', 'operador_id' ,'agenda_id']; 
}
