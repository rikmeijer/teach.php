<?php
function copyStar($target, $source, $offset) {
    if (imagecopyresampled($target, $source, 100 * $offset, (imagesy($target) / 2) - (imagesy($target) / 2), 0, 0, 100, imagesy($target), imagesx($source), imagesy($source)) === false) {
        exit('fail to copy image');
    }
}

$im = imagecreatetruecolor($width, $height);
imagealphablending($im, false);
imagesavealpha($im, true);
imagefilledrectangle($im, 0, 0, 500, imagesy($im), imagecolorallocatealpha($im, 255, 255, 255, 127));

if ($ratingwaarde === null) {
    for ($i = 0; $i < 5; $i++) {
        copyStar($im, imagecreatefromstring($nostar), $i);
    }
} else {
    for ($i = 0; $i < 5; $i++) {
        if ($i < $ratingwaarde) {
            $source = imagecreatefromstring($star);
        } else {
            $source = imagecreatefromstring($unstar);
        }
        copyStar($im, $source, $i);
    }
}

imagepng($im, null, 0);
imagedestroy($im);
imagedestroy($star);