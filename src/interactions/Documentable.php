<?php
namespace Teach\Interactions;

interface Documentable
{

    /**
     *
     * @param \Teach\Interactions\HTML\Factory $factory            
     * @return string
     */
    function document(\Teach\Interactions\Documenter $adapter): string;
}