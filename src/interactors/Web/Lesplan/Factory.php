<?php
namespace Teach\Interactors\Web\Lesplan;

final class Factory
{
    /**
     * 
     * @param string $caption
     * @param array $werkvorm
     * @return \Teach\Interactors\Web\Lesplan\Activiteit
     */
    public function createActiviteit($caption, array $werkvorm)
    {
        return new Activiteit($caption, $werkvorm);
    }
    

    /**
     * 
     * @param string $title
     * @param \Teach\Interactors\Web\Lesplan\Activiteit[]
     * @return \Teach\Interactors\Web\Lesplan\Thema
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
     * @param string $title
     * @return \Teach\Interactors\Web\Lesplan\Fase
     */
    public function createFase($title)
    {
        return new Fase($title);
    }

    /**
     * 
     * @param string $title
     * @param array $activiteitDefinitions
     * @return \Teach\Interactors\Web\Lesplan\Fase
     */
    public function createFaseWithActiviteiten($title, array $activiteitDefinitions)
    {
        $fase = $this->createFase($title);
        foreach ($activiteitDefinitions as $activiteitIdentifier => $activiteitDefinition) {
            $activiteit = $this->createActiviteit($activiteitIdentifier, $activiteitDefinition);
            $fase->addOnderdeel($activiteit);
        }
        return $fase;
    }
    
    /**
     * 
     * @param Activiteit $activerendeOpening
     * @param Activiteit $focus
     * @param Activiteit $voorstellen
     */
    public function createIntroductie(Activiteit $activerendeOpening, Activiteit $focus, Activiteit $voorstellen)
    {
        $fase = $this->createFase("Introductie");
        $fase->addOnderdeel($activerendeOpening);
        $fase->addOnderdeel($focus);
        $fase->addOnderdeel($voorstellen);
        return $fase;
    }

    public function createAfsluiting(Activiteit $huiswerk, Activiteit $feedback, Activiteit $pakkendSlot)
    {
        $fase = $this->createFase("Afsluiting");
        $fase->addOnderdeel($huiswerk);
        $fase->addOnderdeel($feedback);
        $fase->addOnderdeel($pakkendSlot);
        return $fase;
    }
    
    /**
     * 
     * @param array $themas
     * @return \Teach\Interactors\Web\Lesplan\Fase
     */
    public function createKern(array $themas)
    {
        $kern = $this->createFase("Kern");
        $themaCount = 0;
        foreach ($themas as $themaIdentifier => $themaDefinition) {
            $thema = $this->createThema('Thema ' . (++$themaCount) . ': ' . $themaIdentifier, $themaDefinition);
            $kern->addOnderdeel($thema);
        }
        return $kern;
    }

    /**
     * 
     * @param string $opleiding
     * @param array $beginsituatie
     * @return \Teach\Interactors\Web\Lesplan\Beginsituatie
     */
    public function createBeginsituatie($opleiding, array $beginsituatie)
    {
        return new Beginsituatie($opleiding, $beginsituatie);
    }
    
    /**
     * 
     * @param string $les
     * @param Beginsituatie $beginsituatie
     * @param array $media
     * @param array $leerdoelen
     * @return \Teach\Interactors\Web\Lesplan\Contactmoment
     */
    public function createContactmoment($les, Beginsituatie $beginsituatie, array $media, array $leerdoelen)
    {
        return new Contactmoment($les, $beginsituatie, $media, $leerdoelen);
    }
    
    /**
     * 
     * @param array $lesplanDefinition
     * @return \Teach\Interactors\Web\Lesplan
     */
    public function createLesplan($vak, Contactmoment $contactmoment, Fase $introductie, Fase $kern, Fase $afsluiting)
    {
        return new \Teach\Interactors\Web\Lesplan($vak, $contactmoment, $introductie, $kern, $afsluiting);
    }
}