<?php
namespace Teach\Interactions\Web\Lesplan;

final class Factory
{

    /**
     *
     * @param string $caption            
     * @param array $werkvorm            
     * @return \Teach\Interactions\Web\Lesplan\Activiteit
     */
    public function createActiviteit($caption, array $werkvorm)
    {
        return new Activiteit($caption, $werkvorm);
    }

    /***
     * 
     * @param string $title
     * @param \Teach\Interactions\Web\Document\Parts $parts
     * @return \Teach\Interactions\Web\Lesplan\Fase
     */
    public function createFase(string $title, \Teach\Interactions\Web\Document\Parts $parts)
    {
        return new Fase($title, $parts);
    }

    /**
     *
     * @param Activiteit $activerendeOpening            
     * @param Activiteit $focus            
     * @param Activiteit $voorstellen            
     */
    public function createIntroductie(Activiteit $activerendeOpening, Activiteit $focus, Activiteit $voorstellen, Activiteit $kennismaken, Activiteit $terugblik)
    {
        $parts = $this->createDocumentParts($activerendeOpening, $focus, $voorstellen, $kennismaken, $terugblik);
        $fase = $this->createFase("Introductie", $parts);
        return $fase;
    }

    public function createAfsluiting(Activiteit $huiswerk, Activiteit $feedback, Activiteit $pakkendSlot)
    {
        $parts = $this->createDocumentParts($huiswerk, $feedback, $pakkendSlot);
        $fase = $this->createFase("Afsluiting", $parts);
        return $fase;
    }

    /**
     *
     * @param string $les            
     * @param array $beginsituatie            
     * @param array $media            
     * @param array $leerdoelen            
     * @return \Teach\Interactions\Web\Lesplan\Beginsituatie
     */
    public function createBeginsituatie(string $les, array $beginsituatie, array $media, array $leerdoelen)
    {
        return new Beginsituatie($les, $beginsituatie, $media, $leerdoelen);
    }

    /**
     * 
     * @param \Teach\Interactions\Documentable ...$parts
     * @return \Teach\Interactions\Web\Lesplan\Document\Parts
     */
    public function createDocumentParts(\Teach\Interactions\Documentable ...$parts)
    {
        return new \Teach\Interactions\Web\Document\Parts(...$parts);
    }

    /**
     * 
     * @param string $title
     * @param string $subtitle
     * @param \Teach\Interactions\Web\Document\Parts $parts
     * @return \Teach\Interactions\Web\Document
     */
    public function createLesplan(string $title, string $subtitle, \Teach\Interactions\Web\Document\Parts $parts)
    {
        return new \Teach\Interactions\Web\Document($title, $subtitle, $parts);
    }
}