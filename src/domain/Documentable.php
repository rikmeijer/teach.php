<?php
namespace Teach\Domain;

interface Documentable
{

    /***
     * 
     * @param \Teach\Interactions\Documenter $adapter
     * @return string
     */
    function document(\Teach\Interactions\Documenter $adapter): string;
}