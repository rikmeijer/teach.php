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
     * @param string $title            
     * @param
     *            \Teach\Interactions\Web\Lesplan\Activiteit[]
     * @return \Teach\Interactions\Web\Lesplan\Thema
     */
    public function createThema($title, array $activiteiten)
    {
        $thema = new Thema($title);
        foreach ($activiteiten as $activiteitIdentifier => $activiteitDefinition) {
            $thema->addActiviteit($this->createActiviteit($activiteitIdentifier, $activiteitDefinition));
        }
        return $thema;
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
     * @param string $opleiding            
     * @param array $beginsituatie            
     * @param array $media            
     * @param array $leerdoelen            
     * @return \Teach\Interactions\Web\Lesplan\Contactmoment
     */
    public function createContactmoment(array $beginsituatie, array $media, array $leerdoelen)
    {
        return new Contactmoment($beginsituatie, $media, $leerdoelen);
    }

    /**
     *
     * @param string $opleiding            
     * @param string $vak            
     * @param string $les            
     * @param Contactmoment $contactmoment            
     * @param Fase $introductie            
     * @param Fase $kern            
     * @param Fase $afsluiting            
     */
    public function createLesplan($opleiding, $vak, $les, Contactmoment $contactmoment, Fase $introductie, Fase $kern, Fase $afsluiting)
    {
        return new \Teach\Interactions\Web\Lesplan($opleiding, $vak, $les, $contactmoment, $introductie, $kern, $afsluiting);
    }
}