<?php

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Doctrine\Common\Cache\Cache {
    return new Doctrine\Common\Cache\ApcuCache();
};