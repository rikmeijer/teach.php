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

    /**
     *
     * @param string $headerLevel            
     * @param string $title            
     * @return \Teach\Interactions\Web\Lesplan\Fase
     */
    public function createFase($headerLevel, $title)
    {
        return new Fase($headerLevel, $title);
    }

    /**
     *
     * @param Activiteit $activerendeOpening            
     * @param Activiteit $focus            
     * @param Activiteit $voorstellen            
     */
    public function createIntroductie(Activiteit $activerendeOpening, Activiteit $focus, Activiteit $voorstellen, Activiteit $kennismaken, Activiteit $terugblik)
    {
        $fase = $this->createFase('2', "Introductie");
        $fase->addOnderdeel($activerendeOpening);
        $fase->addOnderdeel($focus);
        $fase->addOnderdeel($voorstellen);
        $fase->addOnderdeel($kennismaken);
        $fase->addOnderdeel($terugblik);
        return $fase;
    }

    public function createAfsluiting(Activiteit $huiswerk, Activiteit $feedback, Activiteit $pakkendSlot)
    {
        $fase = $this->createFase('2', "Afsluiting");
        $fase->addOnderdeel($huiswerk);
        $fase->addOnderdeel($feedback);
        $fase->addOnderdeel($pakkendSlot);
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
     * @param string $opleiding            
     * @param string $vak            
     * @param string $les            
     * @param Beginsituatie $contactmoment            
     * @param Fase $introductie            
     * @param Fase $kern            
     * @param Fase $afsluiting            
     */
    public function createLesplan($opleiding, $vak, Beginsituatie $contactmoment, Fase $introductie, Fase $kern, Fase $afsluiting)
    {
        return new \Teach\Interactions\Web\Lesplan($opleiding, $vak, $contactmoment, $introductie, $kern, $afsluiting);
    }
}