<?php

/*
 * |--------------------------------------------------------------------------
 * | Application Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register all of the routes for an application.
 * | It's a breeze. Simply tell Laravel the URIs it should respond to
 * | and give it the controller to call when that URI is requested.
 * |
 */
Route::get('/', function () {
    return view('welcome');
});

Route::get('/lesplan/{contactmoment}', function (App\Contactmoment $contactmoment) {
    $code = request('code');
    $googleService = \OAuth::consumer('Google');
    if ($code === null) {
        return redirect((string) $googleService->getAuthorizationUri() . "&hd=avans.nl");
    }
//     $token = $googleService->requestAccessToken($code);
//     $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
    return view('lesplan', [
        'contactmoment' => $contactmoment
    ]);
});

Route::get('/feedback', function () {
    return view('feedback', [
        'url' => 'http://' . $_SERVER['SERVER_ADDR'] . '/feedback.php'
    ]);
});