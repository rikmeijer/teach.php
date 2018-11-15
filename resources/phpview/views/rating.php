<?php
$height = 100;
$im = imagecreatetruecolor(500, $height);
imagealphablending($im, false);
imagesavealpha($im, true);
$transparent = imagecolorallocatealpha($im, 255, 255, 255, 127);
imagefilledrectangle($im, 0, 0, 500, $height, $transparent);

function copyStar($target, $source, $offset) {
    if (imagecopyresampled($target, $source, 100 * $offset, (100 / 2) - (100 / 2), 0, 0, 100, 100, imagesx($source), imagesy($source)) === false) {
        exit('fail to copy image');
    }
}

if ($ratingwaarde === null) {
    $source = imagecreatefromstring($nostarData);
    for ($i = 0; $i < 5; $i++) {
        copyStar($im, $source, $i);
    }
} else {
    $star = imagecreatefromstring($starData);
    $unstar = imagecreatefromstring($unstarData);
    for ($i = 0; $i < 5; $i++) {
        if ($i < $ratingwaarde) {
            $source = $star;
        } else {
            $source = $unstar;
        }
        copyStar($im, $source, $i);
    }
}

imagepng($im, null, 0);
imagedestroy($im);
imagedestroy($star);