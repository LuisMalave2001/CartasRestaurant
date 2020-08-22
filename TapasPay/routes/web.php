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

Route::get('/google/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/choose-menu', 'ChooseMenuController@showMenuList')->name("choose_menu");
Route::post('/update-shopping-items-count', 'ChooseMenuController@updateShoppingItems')->name("update_shopping_items_count");


Route::middleware('auth')->group(function(){

    Route::any('/', "MenuSetupController@index");

    Route::put('/establishment/{id}', 'Establishment\EstablishmentController@change')->middleware("checkEstablishment");

    //Shopping
    Route::get("/table/{tableHashId}", "Shopping\TableShoppingController@showCarteMenuList")->name("table_shopping");
    Route::get("/table_orders/cart/{tableHashId}", "Shopping\TableShoppingController@showClientCurrentShoppingCart")->name("table_shopping_cart");
    Route::get("/table_orders/{tableHashId}", "Shopping\TableShoppingController@showClientOrderList")->name("table_shopping_order_list");

    Route::post("/table/order_line_cookie/{tableHashId}", "Shopping\TableShoppingController@addCookieOrderLine")->name("add_cookie_order_line");

    // Orders
    Route::get('/pending_order', 'Orders\OrderController@getAllPendingOrders');
    Route::get('/orders/{tableHashId}', 'Orders\OrderController@getAllTableOrders');
    Route::post('/orders/{tableHashId}', 'Orders\OrderController@sendOrder');
    Route::put('/order/{orderId}', 'Orders\OrderController@changeStatus');

    Route::post('/product', 'ProductController@create');
    Route::put('/product/{id}', 'ProductController@update')->where('id', '[0-9]+');
    Route::delete('/product/{id}', 'ProductController@remove')->where('id', '[0-9]+');

    Route::post('/menu', 'MenuController@create');
    Route::put('/menu/{id}', 'MenuController@update')->where('id', '[0-9]+');
    Route::delete('/menu/{id}', 'MenuController@remove')->where('id', '[0-9]+');


    Route::post('/carte-menu', 'CarteMenuController@create');
    Route::put('/carte-menu/{id}', 'CarteMenuController@update')->where('id', '[0-9]+');
    Route::delete('/carte-menu/{id}', 'CarteMenuController@remove')->where('id', '[0-9]+');

    // EstablishmentController
    Route::get("/edit-establishment", "Establishment\EstablishmentController@editView")->name("edit_establishment_form");
    Route::post("/edit-establishment/{establishment_id}", "Establishment\EstablishmentController@update")
        ->name("edit_establishment_update");

    Route::get("/see-tables", "Establishment\SeeTablesController")->name("see_tables");

});


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
