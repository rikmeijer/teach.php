<?php
namespace Teach\Adapters\HTML;

final class Element implements RenderableInterface
{
    const VOIDS = ['br', 'hr', 'img', 'input', 'link', 'meta', 'area', 'base', 'col', 'embed', 'keygen', 'menuitem', 'param', 'source', 'track', 'wbr'];
    
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
    
    public function append(RenderableInterface $child)
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

        $html = '<' . $this->tagName . $attributeHTML . '>';
        if (in_array($this->tagName, self::VOIDS) === false) {
            foreach ($this->children as $child) {
                $html .= $child->render();
            }
        
            $html .= '</' . $this->tagName . '>';
        }
        return $html;
    }
}