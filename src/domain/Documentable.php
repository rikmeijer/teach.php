<?php
namespace Teach\Domain;

interface Documentable
{
    function document(\Teach\Interactions\Documenter $adapter): string;
}