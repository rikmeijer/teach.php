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
    // $token = $googleService->requestAccessToken($code);
    // $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);
    return view('lesplan', [
        'contactmoment' => $contactmoment
    ]);
});
Route::get('/feedback', function () {
    return view('feedback', [
        'url' => 'http://' . $_SERVER['SERVER_ADDR'] . '/feedback/supply'
    ]);
});
Route::get('/feedback/supply', function (\Illuminate\Http\Request $request) {
    $assetsDirectory = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';
    $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $_SERVER['REMOTE_ADDR'] . '.txt';
    
    $imageStar = $assetsDirectory . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'star.png';
    $starData = base64_encode(file_get_contents($imageStar));
    
    $imageUnstar = $assetsDirectory . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'unstar.png';
    $unstarData = base64_encode(file_get_contents($imageUnstar));
    
    if (is_file($filename)) {
        $data = json_decode(file_get_contents($filename), true);
    } else {
        $data = null;
    }
    
    if ($data !== null) {
        $rating = $data['rating'];
        $explanation = $data['explanation'];
    } else {
        $rating = null;
        $explanation = null;
    }

    if ($request->has('rating')) {
        $rating = $request->input('rating');
    }
    
    return view('feedback/supply', [
        'rating' => $rating,
        'explanation' => $explanation,
        'uris' => [
            'star' => 'data: ' . mime_content_type($imageStar) . ';base64,' . $starData,
            'unstar' => 'data: ' . mime_content_type($imageUnstar) . ';base64,' . $unstarData
        ]
    ]);
});
Route::post('/feedback/supply', function () {
    $filename = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . $_SERVER['REMOTE_ADDR'] . '.txt';
    
    file_put_contents($filename, json_encode([
        'rating' => $_POST['rating'],
        'explanation' => $_POST['explanation']
    ]));
    return 'Dankje!';
});

Route::get('/rating', function () {
    $assetsDirectory = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets';
    $dataDirectory = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'data';
    
    $ratings = [];
    foreach (glob($dataDirectory . DIRECTORY_SEPARATOR . '*.txt') as $individualRatingFilename) {
        $individualRating = json_decode(file_get_contents($individualRatingFilename), true);
        if ($individualRating !== null) {
            $ratings[] = $individualRating['rating'];
        }
    }
    if (count($ratings) === 0) {
        $rating = 0;
    } else {
        $rating = round(array_sum($ratings) / count($ratings));
    }

    $imageStar = $assetsDirectory . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'star.png';
    $imageUnstar = $assetsDirectory . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'unstar.png';

    return view('rating', [
        'rating' => $rating,
        'starData' => file_get_contents($imageStar),
        'unstarData' => file_get_contents($imageUnstar),
        'assetsDirectory' => dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'assets'
    ]);
});
Route::get('/qr', function () {
    $data = request('data');
    if ($data === null) {
        return abort(400);
    }
    return view('qr', [
        'data' => $data
    ]);
});