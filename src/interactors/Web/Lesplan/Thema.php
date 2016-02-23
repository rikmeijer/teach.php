<?php
namespace Teach\Interactors\Web\Lesplan;

final class Thema implements \Teach\Interactors\LayoutableInterface
{

    private $title;

    /**
     *
     * @var Activiteit[]
     */
    private $activiteiten = [];

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function addActiviteit(Activiteit $activiteit)
    {
        $this->activiteiten[] = $activiteit;
    }


    /**
     * @param array $variableIdentifiers
     * @return array
     */
    public function provideTemplateVariables(array $variableIdentifiers)
    {
        $variables = [];
        foreach ($variableIdentifiers as $variableIdentifier) {
            switch ($variableIdentifier) {
                case 'title':
                    $variables[$variableIdentifier] = $this->title;
                    break;
                case 'activiteiten':
                    $variables[$variableIdentifier] = $this->activiteiten;
                    break;
            }
        }
        return $variables;
    }
}