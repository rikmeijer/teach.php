<?php
namespace Teach\Adapters;

class Factory
{
    
    public function makeHTMLDocument()
    {
        return new \Teach\Adapters\Document(new \Teach\Adapters\Document\HTML());
    }
}