<?php

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
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){ 
                
        Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function(){
            Route::get('/','WelcomeController@index')->name('welcome');

            //Users
            Route::resource('users','UserController');

            //Categories
            Route::resource('categories','CategoryController');

            //Products
            Route::resource('products','ProductController');

            //Clients
            Route::resource('clients','ClientController');
            Route::resource('clients.orders','Client\OrderController');

            //Orders
            Route::resource('orders','OrderController');
            Route::get('/orders/{order}/products','OrderController@products')->name('orders.products');

        });
    });
