<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Gruppe machen damit man weiß wo was hingehört
Route::group(['middleware' => ['api', 'cors']], function () {
    //methode login im routecontroller aufrufen
    Route::post('auth/login', 'Auth\ApiAuthController@login');
    Route::get('books', 'BookController@index');
    Route::get('book/{isbn}', 'BookController@findByISBN');
    Route::get('book/checkisbn/{isbn}', 'BookController@checkISBN');
    Route::get('books/search/{searchTerm}', 'BookController@findBySearchTerm');
    //getPrice of Book
    Route::get('book/getPrice/{orderid}/{bookid}', 'OrderController@getPrice');
    //getSalesTax from Env File
    Route::get('salesTax', 'OrderController@getSalesTax');
    //Todo: Buch zu Tabelle Order hinzufügen
    //Todo: Hole addresse von user für local storage
});



//alle methoden mit authentifizierung, nicht öffentlich aufrufbar
Route::group(['middleware' => ['api', 'cors', 'jwt-auth']], function () {
    //insert book
    Route::post('book', 'BookController@save');
    //update book
    Route::put('book/{isbn}', 'BookController@update');
    //delete book
    Route::delete('book/{isbn}', 'BookController@delete');
    //logout
    Route::post('auth/logout', 'Auth\ApiAuthController@logout');
    //User zurückbekommen
    Route::get('auth/user', 'Auth\ApiAuthController@getCurrentAuthenticatedUser');
    //insert order
    Route::post('order', 'OrderController@addOrder');
    //show all orders for BE User
    Route::get('orders', 'OrderController@index');
    //filter for order with state
    Route::get('orders/{state}', 'OrderController@findByState');
    //filter for order with username
    Route::get('orders/findByUsername/{username}', 'OrderController@findByUsername');
    //filter for order with userId
    Route::get('orders/findByUserId/{userId}', 'OrderController@findByUserId');
    //get all books from a specific order by the orderid
    Route::get('orders/findBooksByOrderid/{orderid}', 'OrderController@findBooksByOrderid');
    //update the status of a order
    Route::put('update/{orderId}', 'OrderController@updateState');
    //Status von bestellung zurückgeben
    Route::get('order/getState/{orderid}','OrderController@getState');
    //get ordered list of orders, DESC
    Route::get('order/orderedDesc','OrderController@orderByDatetimeDesc');
    //get ordered list of orders from User, DESC
    Route::get('order/orderedDescFromUser/{user_id}','OrderController@orderFromUserByDatetimeDesc');
    //get ordered list of orders, ASC
    Route::get('order/orderedAsc','OrderController@orderByDatetimeAsc');
    //get ordered list of orders from User, ASC
    Route::get('order/orderedAscFromUser/{user_id}','OrderController@orderFromUserByDatetimeAsc');
    //get orderlog
    Route::get('orderlog', 'OrderController@getOrderlog');
    //filter for orderlogs with userId
    Route::get('orderlog/findByUserId/{userId}', 'OrderController@findOrderlogsByUserId');
    //get order with id
    Route::get('order/{orderid}', 'OrderController@getOrderById');
    //filter order by state from user
     Route::get('orders/filterByState/{user_id}/{state}', 'OrderController@findFromUserByState');
     //getUseraddress with id
    Route::get('user/address/{userid}', 'BookController@getAddressFromUser');
});



