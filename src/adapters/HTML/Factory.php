<?php
namespace Teach\Adapters\HTML;

final class Factory
{

    const TAG = 0;

    const ATTRIBUTES = 1;

    const TEXT = 1;

    const CHILDREN = 2;

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
        
        foreach ($elements as $elementDefinition) {
            $element->append($this->convertDefinition($elementDefinition));
        }
        return $element;
    }

    public function createText($text)
    {
        return new Text($text);
    }

    /**
     *
     * @param array $elementDefinition            
     * @return RenderableInterface
     */
    private function convertDefinition($elementDefinition)
    {
        if (is_string($elementDefinition)) {
            return $this->createText($elementDefinition);
        } elseif (is_string($elementDefinition[1])) {
            return $this->convertDefinition([
                $elementDefinition[0],
                [],
                [
                    $elementDefinition[1]
                ]
            ]);
        } else {
            return $this->createElement($elementDefinition[0], $elementDefinition[1], $elementDefinition[2]);
        }
    }

    public function makeHTML(array $elements)
    {
        $html = '';
        foreach ($elements as $elementDefinition) {
            $html .= $this->convertDefinition($elementDefinition)->render();
        }
        return $html;
    }

    public function makeHTMLFrom(LayoutableInterface $layoutable)
    {
        return $this->makeHTML($layoutable->generateHTMLLayout());
    }
}