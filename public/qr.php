<?php
if (array_key_exists('data', $_GET) === false) {
    http_response_code(400);
    exit();
}
require __DIR__.'/../bootstrap/autoload.php';

$renderer = new \BaconQrCode\Renderer\Image\Png();
$renderer->setHeight(400);
$renderer->setWidth(400);
$writer = new \BaconQrCode\Writer($renderer);

header('Content-Type: image/png');
print $writer->writeString($_GET['data']);
exit();