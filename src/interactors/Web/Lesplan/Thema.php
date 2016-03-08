<?php
namespace Teach\Interactors\Web\Lesplan;

final class Thema implements \Teach\Interactors\PresentableInterface
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
    
    public function present(\Teach\Adapters\HTML\Factory $factory): string
    {
        $section = $factory->makeSection();
        $section->append($factory->makeHeader('3', $this->title));
        foreach ($this->activiteiten as $activiteit) {
            $section->appendHTML($activiteit->present($factory));
        }
        return $section->render();
    }
}