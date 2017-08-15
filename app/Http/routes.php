<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);


//Route::get('calendar', 'CalendarController@index');
Route::resource('calendar','CalendarController');


Route::resource('gcalendar', 'gCalendarController');
Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'gCalendarController@oauth']);


//Route::post('/guardar', array('as'=>'guardar','uses'=>'gCalendarController@store'));

Route::post('gcalendar/sstore','gCalendarController@store');
Route::post('gcalendar/uupdate','gCalendarController@update');

Route::post('gcalendar/ddestroy','gCalendarController@destroy');

//Route::get('gcalendar/{id}/destroy',['uses'=>'gCalendarController@destroy','as'=>'gCalendarController.destroy']);

Route::get('gcalendar/new2',['uses'=>'gCalendarController@NewCalendar','as'=>'gCalendarController@NewCalendar']);
Route::get('gcalendar/new','gCalendarController@show');

Route::resource('Ordenes','OrdenesTabrajoController');