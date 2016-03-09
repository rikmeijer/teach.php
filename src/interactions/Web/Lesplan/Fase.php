<?php
namespace Teach\Interactions\Web\Lesplan;

final class Fase implements \Teach\Interactions\Documentable
{

    private $title;

    /**
     *
     * @var \Teach\Interactions\Documentable[]
     */
    private $onderdelen = array();

    public function __construct($title)
    {
        $this->title = $title;
    }

    public function addOnderdeel(\Teach\Interactions\Documentable $onderdeel)
    {
        $this->onderdelen[] = $onderdeel;
    }

    public function present(\Teach\Interactions\Documenter $adapter): string
    {
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader('2', $this->title));
        foreach ($this->onderdelen as $activiteit) {
            $section->appendHTML($activiteit->present($adapter));
        }
        return $section->render();
    }
}