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
Route::get('/', 'BooksController@welcome');

Route::post('/book', 'BooksController@store');
Route::get('/books', 'BooksController@index');
Route::get('/book/{id}', 'BooksController@getbook');
Route::get('/bookInfo/{id}', 'BooksController@getbookInfo');
Route::delete('/book/{id}', 'BooksController@delete');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('libro/{id}','BooksController@getBook');
Route::get('addBook','BooksController@addBook');
Route::get('addSamples','BooksController@addSamples');