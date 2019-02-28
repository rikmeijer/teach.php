<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\View\Template;

interface UseCase
{
    public function view(array $urlParameters): Template;
}