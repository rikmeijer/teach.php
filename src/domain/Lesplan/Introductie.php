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

    public function document(\Teach\Domain\Documenter $documenter): string
    {
        $section = $documenter->makeSection();
        $section->append($documenter->makeHeader("2", "Introductie"));
        $section->appendHTML($this->opening->document($documenter), $this->focus->document($documenter), $this->voorstellen->document($documenter), $this->kennismaken->document($documenter), $this->terugblik->document($documenter));
        return $section->render();
    }
}