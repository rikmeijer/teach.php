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
        foreach ($elements as $elementDefinition) {
            $element->append(new Text($elementDefinition));
        }
        return $element;
    }
}