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

// Route::get('/', function () {
//     return view('welcome');
// });

// Rota de controle do Vue Router
// Redireciona para objeto VueRouter (.\resources\js\app.js) e impede de gerar 404 Not Found
// Redireciona NotFoundUrl para Home
// Route::get('/{vue?}', 'HomeController@index')->where('vue', '[\/\w\.-]*');

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::any('{query}', function() { return redirect('/'); })->where('query', '.*');
