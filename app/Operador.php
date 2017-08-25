<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Operador extends Model
{
   // use CrudTrait;
	protected $table ="operador";
	protected $fillable = ['nombre','rut','direccion','contacto','telefono','email','comuna_id','url','tipo','gcalendar_id','ocalendar_id','created_at'
       ];


/*
  public function equipos(){

   return	$this->hasMany('App\Equipo','operador_id');
  }    
 

   public function comuna()
    {
      return $this->belongsTo('App\Comuna');
    }   
    //para insertar select region, prov, comuna
    public function region() {

    	return $this->belongsTo('App\Region');
    }
*/
 
}
