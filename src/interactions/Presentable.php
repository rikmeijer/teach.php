<?php
namespace Teach\Interactions;

interface Presentable
{

    /**
     *
     * @param \Teach\Interactions\HTML\Factory $factory            
     * @return string
     */
    function present(\Teach\Interactions\Documenter $adapter): string;
}