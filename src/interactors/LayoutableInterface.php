<?php
namespace Teach\Interactors;

interface LayoutableInterface
{


    /**
     * @param array $variableIdentifiers
     * @return array
     */
    function provideTemplateVariables(array $variableIdentifiers);
    
}