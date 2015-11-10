<?php
namespace Teach\Adapters;

interface LayoutableInterface
{

    function generateLayout(\Teach\Adapters\LayoutFactoryInterface $factory);
}