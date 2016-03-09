<?php
namespace Teach\Interactors;

class Factory
{
    
    public function makeHTMLDocument()
    {
        return new \Teach\Interactors\Document(new \Teach\Interactors\Document\HTML());
    }
}