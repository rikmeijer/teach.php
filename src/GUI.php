<?php

namespace rikmeijer\Teach;

interface GUI
{
    public function addRoutesToRouter(\pulledbits\Router\Router $router): void;
}
