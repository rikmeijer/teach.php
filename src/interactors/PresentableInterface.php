<?php
namespace Teach\Interactors;

interface PresentableInterface
{
    
    /**
     * 
     * @param \Teach\Adapters\HTML\Factory $factory
     * @return string
     */
    function present(\Teach\Adapters\Documentable $adapter): string;
}