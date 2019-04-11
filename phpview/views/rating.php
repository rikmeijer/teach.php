<?php
$im = imagecreatetruecolor($ratingWidth, $ratingHeight);
imagealphablending($im, false);
imagesavealpha($im, true);
imagefilledrectangle($im, 0, 0, $ratingWidth, $ratingHeight, imagecolorallocatealpha($im, 255, 255, 255, 127));

$star = imagecreatefromstring($this->star());
$unstar = imagecreatefromstring($this->unstar());
$nostar = imagecreatefromstring($this->nostar());

$sourceWidth = imagesx($star);
$sourceHeight = imagesy($star);

$starWidth = $ratingWidth / $repetition;
$starHeight = $ratingHeight;

if ($ratingwaarde === 0) {
    for ($offset = 0; $offset < $repetition; $offset++) {
        imagecopyresampled(
            $im,
            $nostar,
            $starWidth * $offset,
            ($ratingHeight / 2) - ($ratingHeight / 2),
            0,
            0,
            $starWidth,
            $ratingHeight,
            $sourceWidth,
            $sourceHeight
        );
    }
} else {
    for ($offset = 0; $offset < $repetition; $offset++) {
        if ($offset < $ratingwaarde) {
            $source = $star;
        } else {
            $source = $unstar;
        }
        imagecopyresampled(
            $im,
            $source,
            $starWidth * $offset,
            ($ratingHeight / 2) - ($ratingHeight / 2),
            0,
            0,
            $starWidth,
            $ratingHeight,
            $sourceWidth,
            $sourceHeight
        );
    }
}


imagepng($im, null, 0);
imagedestroy($im);
imagedestroy($star);
