<?php
namespace Teach\Interactors;

interface LayoutableInterface
{

    function generateLayout(LayoutFactoryInterface $factory);
}