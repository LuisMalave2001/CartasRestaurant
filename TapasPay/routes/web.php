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

Route::get("/phpinfo", function(){
       return phpinfo();
});

Route::get('/google/redirect', 'Auth\LoginController@redirectToProvider');
Route::get('/google/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/choose-menu', 'ChooseEstablishmentController@showMenuList')->name("choose_establishment");
Route::post('/update-shopping-items-count', 'ChooseEstablishmentController@updateShoppingItems')->name("update_shopping_items_count");


Route::middleware('auth')->group(function(){

    Route::any('/', "MenuSetupController@index");

    Route::put('/establishment/{id}', 'Establishment\EstablishmentController@change')->middleware("checkEstablishment");

    //Shopping
    Route::get("/table/{tableHashId}", "Shopping\TableShoppingController@showCarteMenuList")->name("table_shopping");
    Route::get("/table_orders/cart/{tableHashId}", "Shopping\TableShoppingController@showClientCurrentShoppingCart")->name("table_shopping_cart");
    Route::get("/table_orders/{tableHashId}", "Shopping\TableShoppingController@showClientOrderList")->name("table_shopping_order_list");
    Route::put("/table_orders/{tableHashId}/line/{orderLineIndex}", "Shopping\TableShoppingController@updateOrderLine");//->name("table_shopping_order_list");
    Route::delete("/table_orders/{tableHashId}/line/{orderLineIndex}", "Shopping\TableShoppingController@deleteOrderLine");

    Route::post("/table/order_line_cookie/{tableHashId}", "Shopping\TableShoppingController@addCookieOrderLine")->name("add_cookie_order_line");

    // Orders
    Route::get('/pending_order', 'Orders\OrderController@getAllPendingOrders');
    Route::get('/orders/{tableHashId}', 'Orders\OrderController@getAllTableOrders');
    Route::post('/orders/{tableHashId}', 'Orders\OrderController@submitOrder')->name("submit_order_lines");
    Route::put('/order/{orderId}', 'Orders\OrderController@changeStatus');
    Route::delete('/order_line/{tableHashId}/{orderId}', 'Orders\OrderController@deleteCookieOrderLine');

    // Product
    Route::post('/product', 'ProductController@create');
    Route::put('/product/{id}', 'ProductController@update')->where('id', '[0-9]+');
    Route::delete('/product/{id}', 'ProductController@remove')->where('id', '[0-9]+');

    // Menus
    Route::post('/menu', 'MenuController@create');
    Route::put('/menu/{id}', 'MenuController@update')->where('id', '[0-9]+');
    Route::put('/menu/product_relations', 'MenuController@updateProductRelations');
    Route::delete('/menu/{id}', 'MenuController@remove')->where('id', '[0-9]+');

    // CarteMenu
    Route::post('/carte-menu', 'CarteMenuController@create');
    Route::put('/carte-menu/{id}', 'CarteMenuController@update')->where('id', '[0-9]+');
    Route::put('/carte_menu/item_relations', 'CarteMenuController@updateItemsRelations');
    Route::delete('/carte-menu/{id}', 'CarteMenuController@remove')->where('id', '[0-9]+');

    // EstablishmentController
    Route::get("/edit-establishment", "Establishment\EstablishmentController@editView")->name("edit_establishment_form");
    Route::post("/edit-establishment/{establishment_id}", "Establishment\EstablishmentController@update")->name("edit_establishment_update");
    Route::post("/establishment/", "Establishment\EstablishmentController@create")->name("create_establishment");

    // Categories
    Route::get("/see-tables", "Establishment\SeeTablesController")->name("see_tables");
    Route::get("/establishment/{establishment_id}/categories", "Establishment\CategoriesController@getCategoriesPage")->name("see_categories");
    Route::post("/establishment/{establishment_id}/categories", "Establishment\CategoriesController@createCategory")->name("submit_categories");
    Route::put("/establishment/{establishment_id}/categories", "Establishment\CategoriesController@updateCategory")->name("submit_categories");
    Route::delete("/category/{category}", "Establishment\CategoriesController@deleteCategory")->name("delete_category");

});


Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
