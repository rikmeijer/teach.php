<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\View\Template;

interface GUI
{
    public function view(array $urlParameters): Template;
}