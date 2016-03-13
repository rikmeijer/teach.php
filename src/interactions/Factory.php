<?php
namespace Teach\Interactions;

class Factory
{

    public function makeDocument(Documenter $adapter)
    {
        return new \Teach\Interactions\Document($adapter);
    }
}