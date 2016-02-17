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
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        $activiteitenHTML = [];
        foreach ($this->activiteiten as $activiteit) {
            $activiteitenHTML = array_merge($activiteitenHTML, $activiteit->generateLayout ($factory));
        }
        
        return [
            $factory->makeSection($factory->makeHeader3($this->title), $activiteitenHTML)
        ];
    }

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