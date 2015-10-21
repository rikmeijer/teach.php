<?php
namespace Teach\Adapters\HTML;

final class Factory
{
    /**
     * 
     * @param array $definition
     * @return Element
     */
    public function createElement(array $definition)
    {
        foreach ($definition as $elementIdentifier => $elementDefinition) {
            $element = new Element($elementIdentifier);
            $element->append(new Text($elementDefinition[0]));
        }
        return $element;
    }
}