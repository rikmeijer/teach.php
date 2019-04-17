<?php

use Psr\Log\LoggerInterface;

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : LoggerInterface {
    return new Monolog\Logger("pulledbits/teach");
};