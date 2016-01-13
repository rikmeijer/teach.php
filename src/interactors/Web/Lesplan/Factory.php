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
     * @param Activiteit $activerendeOpening
     * @param Activiteit $focus
     * @param Activiteit $voorstellen
     */
    public function createIntroductie(Activiteit $activerendeOpening, Activiteit $focus)
    {
        $fase = $this->createFase("Introductie");
        $fase->addOnderdeel($activerendeOpening);
        $fase->addOnderdeel($focus);
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
     * @param array $media
     * @param array $leerdoelen
     * @return \Teach\Interactors\Web\Lesplan\Contactmoment
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
        return new \Teach\Interactors\Web\Lesplan($opleiding, $vak, $les, $contactmoment, $introductie, $kern, $afsluiting);
    }
}