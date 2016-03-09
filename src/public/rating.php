<?php
$applicationBootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php';

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
header("Content-type: image/png");
$height = 100;
$im = imagecreatetruecolor(500, $height);
imagealphablending($im, false);
imagesavealpha($im, true);
$transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
imagefilledrectangle($im, 0, 0, 500, $height, $transparent);
$star = imagecreatefrompng(__DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'star.png');
$unstar = imagecreatefrompng(__DIR__ . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'unstar.png');
for ($i = 0; $i < 5; $i ++) {
    if ($i < $rating) {
        $source = $star;
    } else {
        $source = $unstar;
    }
    if (imagecopyresampled($im, $source, 100 * $i, ($height / 2) - (100 / 2), 0, 0, 100, 100, imagesx($source), imagesy($source)) === false) {
        exit('fail to copy image');
    }
}
imagepng($im, null, 0);
imagedestroy($im);
imagedestroy($star);