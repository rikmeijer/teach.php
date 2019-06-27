<?php
$bootstrap = require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'application.php';
chdir($bootstrap->root());
exec( './deploy.sh', $output, $return);
if ($return !== 0) {
    http_response_code(500);
    file_put_contents($bootstrap->root() . DIRECTORY_SEPARATOR . 'deploy.log', print_r($output, true) );
    exit('ERR');
}
exit('OK');
