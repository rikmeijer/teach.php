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

Route::prefix('contactmomenten')->name('contactmomenten.')->group(
    function () {
        Route::get(
            'importeer',
            function () {
                return view('contactmomenten.importeer');
            }
        )->name('importeer');

        Route::post('importeer', 'ContactmomentenController@importeer')->name('importeer');

        Route::get(
            'geimporteerd',
            function () {
                return view('contactmomenten.geimporteerd');
            }
        )->name('geimporteerd');
    }
);

Auth::routes();
