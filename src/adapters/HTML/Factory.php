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
            if (is_string($elementDefinition)) {
                $element->append(new Text($elementDefinition));
            } else {
                $element->append($this->createElement($childTagname, $elementDefinition[0], $elementDefinition[1]));
            }
        }
        return $element;
    }
}