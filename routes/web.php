<?php declare(strict_types=1);

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

Route::get('/', 'HomeController@index')->name('home');

Route::get(
    '/contactmomenten/importeer',
    function () {
        return view('contactmomenten.importeer');
    }
)->name('contactmomenten.importeer');

Route::post('/contactmomenten/importeer', 'ContactmomentenController@importeer')->name('contactmomenten.importeer');

Route::get(
    '/contactmomenten/geimporteerd',
    function () {
        return view('contactmomenten.geimporteerd');
    }
)->name('contactmomenten.geimporteerd');

Auth::routes();
