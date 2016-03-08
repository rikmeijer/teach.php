<?php
namespace Teach\Interactors;

interface LayoutableInterface
{
    
    /**
     * 
     * @param \Teach\Adapters\HTML\Factory $factory
     * @return string
     */
    function present(\Teach\Adapters\HTML\Factory $factory): string;
}