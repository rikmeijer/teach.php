<?php
namespace Teach\Adapters\HTML;

interface LayoutableInterface
{

    function generateHTMLLayout(Factory $factory);
}