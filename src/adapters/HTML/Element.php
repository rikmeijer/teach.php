<?php
namespace Teach\Adapters\HTML;

final class Element
{
    private $tagName;
    private $attributes = array();
    
    /**
     * 
     * @var Element[]
     */
    private $children = array();
    
    public function __construct($tagName)
    {
        $this->tagName = $tagName;
    }
    
    public function attribute($attributeIdentifier, $attributeValue)
    {
        $this->attributes[] = $attributeIdentifier . '="' . $attributeValue . '"';
    }
    
    public function child(Element $child)
    {
        $this->children[] = $child;
    }
    
    public function render()
    {
        if (count($this->attributes) === 0) {
            $attributeHTML = '';
        } else {
            $attributeHTML = ' ' . join(' ', $this->attributes);
        }

        $childrenHTML = '';
        foreach ($this->children as $child) {
            $childrenHTML .= $child->render();
        }
        
        return '<' . $this->tagName . $attributeHTML . '>' . $childrenHTML . '</' . $this->tagName . '>';
    }
}