<?php
namespace Teach\Interactors\Web\Lesplan;

final class Fase implements \Teach\Interactors\LayoutableInterface
{

    private $title;
    
    /**
     * 
     * @var \Teach\Interactors\LayoutableInterface[]
     */
    private $onderdelen = array();

    public function __construct($title)
    {
        $this->title = $title;
    }
    
    public function addOnderdeel(\Teach\Interactors\LayoutableInterface $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    public function present(\Teach\Adapters\HTML\Factory $factory): string
    {
        $section = $factory->makeSection();
        $section->append($factory->makeHeader('2', $this->title));
        foreach ($this->onderdelen as $activiteit) {
            $section->appendHTML($activiteit->present($factory));
        }
        return $section->render();
    }
}