<?php
namespace Teach\Adapters\HTML;

final class Factory
{

    /**
     *
     * @param array $definition            
     * @return Element
     */
    public function createElement($tagName, array $attributes, array $elements)
    {
        $element = new Element($tagName);
        
        foreach ($attributes as $attributeIdentifier => $attributeValue) {
            $element->attribute($attributeIdentifier, $attributeValue);
        }
        
        foreach ($elements as $childTagname => $elementDefinition) {
            $element->append($this->convertDefinition($childTagname, $elementDefinition));
        }
        return $element;
    }

    private function createText($text)
    {
        return new Text($text);
    }

    /**
     *
     * @param array $elementDefinition            
     * @return RenderableInterface
     */
    private function convertDefinition($elementIdentifier, $elementDefinition)
    {
        if (is_string($elementDefinition)) {
            return $this->createText($elementDefinition);
        } else {
            return $this->createElement($elementIdentifier, $elementDefinition[0], $elementDefinition[1]);
        }
    }

    public function makeHTML(array $elements)
    {
        $html = '';
        foreach ($elements as $elementIdentifier => $elementDefinition) {
            $html .= $this->convertDefinition($elementIdentifier, $elementDefinition)->render();
        }
        return $html;
    }
}