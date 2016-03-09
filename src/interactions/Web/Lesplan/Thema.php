<?php
namespace Teach\Interactions\Web\Lesplan;

final class Thema implements \Teach\Interactions\Documentable
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

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader('3', $this->title));
        foreach ($this->activiteiten as $activiteit) {
            $section->appendHTML($activiteit->document($adapter));
        }
        return $section->render();
    }
}