<?php

return function (\pulledbits\Bootstrap\Bootstrap $bootstrap) : \Auth0\SDK\Auth0 {
    return new \Auth0\SDK\Auth0($bootstrap->config('AUTH0'));
};
