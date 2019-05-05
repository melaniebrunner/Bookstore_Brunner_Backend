<?php

use App\Book;

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

// In einer Route sollte eigentlich kein Datenbankcode drinnen sein
// Das soltle in einem COntroller zwischen geschalten werden
// Dispatcher, Route verteilt nur die Request . Zum Beispiel and das Model
/*
 * */


Route::get('/', 'BookController@index');
Route::get('/books', 'BookController@index');
Route::get('/book/{book}', 'BookController@show');

/*

Route::get('/', function () {
    $books = Book::all();

    return view('welcome', [
        'name' => $name
    ]);

    // verkürzte Schreibweisemöglichkeit mit larvel mit varname , macht das gleiche wie oben
    return view('books.index', compact('books'));
});



Route::get('/books/{id}', function ($id) {

    $book = Book::find($id);
    dd($book);
    return view('books.show', compact('book'));
    //hier müsste man dann die show view ausprogrammieren
}); */


