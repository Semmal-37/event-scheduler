<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('calendar/create-event', 'HomeController@index')->name('create-event');
Route::post('calendar/creat-eevent', 'EventController@create')->name('event');
Route::get('calendar/schedules', 'EventController@index')->name('schedules');
