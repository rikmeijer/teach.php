<?php
echo "Regenerating Daos and Beans...";
/**
 * @var \TheCodingMachine\TDBM\TDBMService $tdbm
 */
$tdbm = (require __DIR__ . DIRECTORY_SEPARATOR . 'bootstrap.php')->resource('tdbm');
$tdbm->generateAllDaosAndBeans();
echo 'OK' . PHP_EOL;