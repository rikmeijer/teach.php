<?php
namespace Teach\Adapters\Web\Lesplan;

final class Factory
{
    /**
     * 
     * @param string $caption
     * @param array $werkvorm
     * @return \Teach\Adapters\Web\Lesplan\Activiteit
     */
    public function createActiviteit($caption, array $werkvorm)
    {
        return new Activiteit($caption, $werkvorm);
    }
    

    /**
     * 
     * @param string $title
     * @param \Teach\Adapters\Web\Lesplan\Activiteit[]
     * @return \Teach\Adapters\Web\Lesplan\Thema
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
     * @return \Teach\Adapters\Web\Lesplan\Fase
     */
    public function createFase($title)
    {
        return new Fase($title);
    }

    /**
     * 
     * @param string $title
     * @param array $activiteitDefinitions
     * @return \Teach\Adapters\Web\Lesplan\Fase
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
     * @return \Teach\Adapters\Web\Lesplan\Fase
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
     * @return \Teach\Adapters\Web\Lesplan\Beginsituatie
     */
    public function createBeginsituatie($opleiding, array $beginsituatie)
    {
        return new Beginsituatie($opleiding, $beginsituatie);
    }
}