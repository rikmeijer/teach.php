<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {

    return function(string $calendarIdentifier) use ($bootstrap) {
        return new \rikmeijer\Teach\Calendar($bootstrap);
    };
};
