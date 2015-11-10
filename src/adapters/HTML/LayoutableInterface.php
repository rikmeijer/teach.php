<?php
namespace Teach\Adapters\HTML;

interface LayoutableInterface
{

    function generateLayout(\Teach\Adapters\LayoutFactoryInterface $factory);
}