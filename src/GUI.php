<?php

namespace rikmeijer\Teach;

use pulledbits\View\Template;

interface GUI
{
    public function view(array $urlParameters): Template;
}