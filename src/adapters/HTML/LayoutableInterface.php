<?php
namespace Teach\Adapters\HTML;

interface LayoutableInterface
{

    function generateHTMLLayout(\Teach\Adapters\LayoutFactoryInterface $factory);
}