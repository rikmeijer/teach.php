<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap): callable {
    return function (string $identifier) {
        return new \Eluceo\iCal\Component\Calendar($identifier);
    };
};
