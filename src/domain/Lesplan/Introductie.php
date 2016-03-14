<?php
namespace Teach\Domain\Lesplan;

class Introductie implements \Teach\Interactions\Interactable, \Teach\Interactions\Documentable
{

    /**
     *
     * @var Activiteit
     */
    private $opening;

    /**
     *
     * @var Activiteit
     */
    private $focus;

    /**
     *
     * @var Activiteit
     */
    private $voorstellen;

    /**
     *
     * @var Activiteit
     */
    private $kennismaken;

    /**
     *
     * @var Activiteit
     */
    private $terugblik;

    public function __construct(Activiteit $opening, Activiteit $focus, Activiteit $voorstellen, Activiteit $kennismaken, Activiteit $terugblik)
    {
        $this->opening = $opening;
        $this->focus = $focus;
        $this->voorstellen = $voorstellen;
        $this->kennismaken = $kennismaken;
        $this->terugblik = $terugblik;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Factory $factory): \Teach\Interactions\Documentable
    {
        $parts = $factory->createDocumentParts($this->opening->interact($factory), $this->focus->interact($factory), $this->voorstellen->interact($factory), $this->kennismaken->interact($factory), $this->terugblik->interact($factory));
        return $factory->createSection("Introductie", $parts);
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested("Introductie"));
        $section->appendHTML($this->opening->document($adapter), $this->focus->document($adapter), $this->voorstellen->document($adapter), $this->kennismaken->document($adapter), $this->terugblik->document($adapter));
        $adapter->pop();
        return $section->render();
    }
}