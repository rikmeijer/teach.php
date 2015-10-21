<?php
namespace Teach\Adapters\HTML;

final class Element
{
    private $tagName;
    private $attributes = array();
    
    public function __construct($tagName)
    {
        $this->tagName = $tagName;
    }
    
    public function attribute($attributeIdentifier, $attributeValue)
    {
        $this->attributes[] = $attributeIdentifier . '="' . $attributeValue . '"';
    }
    
    public function render()
    {
        if (count($this->attributes) === 0) {
            $attributeHTML = '';
        } else {
            $attributeHTML = ' ' . join(' ', $this->attributes);
        }
        return '<' . $this->tagName . $attributeHTML . '></' . $this->tagName . '>';
    }
}