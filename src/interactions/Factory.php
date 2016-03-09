<?php
namespace Teach\Interactions;

class Factory
{

    public function makeHTMLDocument()
    {
        return new \Teach\Interactions\Document(new \Teach\Interactions\Document\HTML());
    }
}