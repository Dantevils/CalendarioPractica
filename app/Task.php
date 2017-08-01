<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model {

	//
protected $fillable = ['id', 'nombre', 'descripcion','fecha_inicio','fecha_fin','Color','allDay','url'];

}