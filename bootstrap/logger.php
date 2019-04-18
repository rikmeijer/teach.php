<?php

use Psr\Log\LoggerInterface;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : LoggerInterface {
    $logger = new Monolog\Logger("pulledbits/teach");
    $logger->pushHandler(new \Monolog\Handler\SyslogHandler("debug", ));
    return $logger;
};