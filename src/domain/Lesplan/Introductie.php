<?php
namespace Teach\Domain\Lesplan;

class Introductie implements \Teach\Interactions\Interactable
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
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        $parts = $factory->createDocumentParts($this->opening->interact($factory), $this->focus->interact($factory), $this->voorstellen->interact($factory), $this->kennismaken->interact($factory), $this->terugblik->interact($factory));
        return $factory->createSection("Introductie", $parts);
    }
}