<?php return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) {

    return function(string $calendarIdentifier) use ($bootstrap) {
        $class = '\\rikmeijer\\Teach\\Calendar\\' . ucfirst($calendarIdentifier);
        return new $class($bootstrap);
    };
};
