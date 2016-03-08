<?php
namespace Teach\Adapters\HTML;

final class Element implements \Teach\Adapters\RenderableInterface
{

    const VOIDS = [
        'br',
        'hr',
        'img',
        'input',
        'link',
        'meta',
        'area',
        'base',
        'col',
        'embed',
        'keygen',
        'menuitem',
        'param',
        'source',
        'track',
        'wbr'
    ];

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

    public function append(\Teach\Adapters\RenderableInterface ...$children)
    {
        $this->children = array_merge($this->children, $children);
    }
    
    public function appendHTML(string ...$children)
    {
        $this->children = array_merge($this->children, $children);
    }

    public function render(): string
    {
        if (count($this->attributes) === 0) {
            $attributeHTML = '';
        } else {
            $attributeHTML = ' ' . join(' ', $this->attributes);
        }

        $html = '';
        if ($this->tagName === 'html') {
            $html .= '<!DOCTYPE html>';
        }
        
        $html .= '<' . $this->tagName . $attributeHTML . '>';
        if (in_array($this->tagName, self::VOIDS) === false) {
            foreach ($this->children as $child) {
                if (is_string($child)) {
                    $html .= $child;
                } else {
                    $html .= $child->render();
                }
            }
            
            $html .= '</' . $this->tagName . '>';
        }
        return $html;
    }
}