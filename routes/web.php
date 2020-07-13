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

Route::get('/', function () {return view('welcome');});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');
Route::get('/event', 'EventsController@index')->name('events')->middleware('auth');

Route::post('/date','EventsController@date')->name('event')->middleware('auth');
Route::post('/event/pdf_download', 'EventsController@pdfDownload')->name('pdf_down')->middleware('auth');
