<?php

namespace rikmeijer\Teach;

use Aura\Router\Map;

interface GUI
{
    public function mapRoutes(Map $map) : void;
}
