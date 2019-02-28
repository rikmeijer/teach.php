<?php

namespace rikmeijer\Teach\GUI;

use pulledbits\View\Template;

interface UseCase
{
    public function makeView(array $matches): Template;
}