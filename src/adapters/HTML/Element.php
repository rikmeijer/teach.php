<?php
namespace Teach\Adapters\HTML;

final class Element
{
    private $tagName;
    
    public function __construct($tagName)
    {
        $this->tagName = $tagName;
    }
    
    public function render()
    {
        return '<' . $this->tagName . '></' . $this->tagName . '>';
    }
}