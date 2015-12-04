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
     * @param array $lesplanDefinition
     * @return \Teach\Interactors\Web\Lesplan
     */
    public function createLesplan(array $lesplanDefinition)
    {
        $beginsituatie = $this->createBeginsituatie($lesplanDefinition['opleiding'], $lesplanDefinition['Beginsituatie']);
        $introductie = $this->createFaseWithActiviteiten('Introductie', $lesplanDefinition['Introductie']);
        $kern = $this->createKern($lesplanDefinition['Kern']);
        $afsluiting = $this->createFaseWithActiviteiten('Afsluiting', $lesplanDefinition['Afsluiting']);
        $contactmoment = new \Teach\Interactors\Web\Contactmoment($lesplanDefinition['les'], $beginsituatie, $lesplanDefinition['media'], array_keys($lesplanDefinition['Kern']));
        return new \Teach\Interactors\Web\Lesplan($lesplanDefinition['vak'], $contactmoment, $introductie, $kern, $afsluiting);
    }
}