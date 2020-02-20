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
        Route::prefix('importeer')->name('importeer')->group(
            function () {
                Route::get(
                    '',
                    'ContactmomentenController@importeerForm'
                );

                Route::post('', 'ContactmomentenController@importeer');
            }
        );

        Route::get(
            'geimporteerd',
            'ContactmomentenController@geimporteerd'
        )->name('geimporteerd');
    }
);

Auth::routes();
