<?php
namespace Teach\Domain;

interface Documentable
{
    function document(\Teach\Domain\Documenter $adapter): string;
}