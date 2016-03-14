<?php
namespace Teach\Domain\Lesplan;

class Introductie implements \Teach\Domain\Documentable
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

    public function document(\Teach\Domain\Documenter $adapter): string
    {
        $adapter->push();
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeaderNested("Introductie"));
        $section->appendHTML($this->opening->document($adapter), $this->focus->document($adapter), $this->voorstellen->document($adapter), $this->kennismaken->document($adapter), $this->terugblik->document($adapter));
        $adapter->pop();
        return $section->render();
    }
}