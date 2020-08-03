<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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



Route::middleware('auth')->group(function(){

    Route::any('/', "MenuSetupController@index");

    Route::put('/establishment/{id}', 'EstablishmentController@change')->middleware("checkEstablishment");


    Route::post('/product', 'ProductController@create');
    Route::put('/product/{id}', 'ProductController@update')->where('id', '[0-9]+');
    Route::delete('/product/{id}', 'ProductController@remove')->where('id', '[0-9]+');

    Route::post('/menu', 'MenuController@create');
    Route::put('/menu/{id}', 'MenuController@update')->where('id', '[0-9]+');
    Route::delete('/menu/{id}', 'MenuController@remove')->where('id', '[0-9]+');


    Route::post('/carte-menu', 'CarteMenuController@create');
    Route::put('/carte-menu/{id}', 'CarteMenuController@update')->where('id', '[0-9]+');
    Route::delete('/carte-menu/{id}', 'CarteMenuController@remove')->where('id', '[0-9]+');

});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
