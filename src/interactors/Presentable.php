<?php
namespace Teach\Interactors;

interface Presentable
{
    
    /**
     * 
     * @param \Teach\Interactors\HTML\Factory $factory
     * @return string
     */
    function present(\Teach\Interactors\Documenter $adapter): string;
}