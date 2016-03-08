<?php
namespace Teach\Domain;

class Lesplan implements \Teach\Interactors\InteractableInterface
{

    /**
     *
     * @var Factory
     */
    private $factory;

    /**
     *
     * @var Lesplan\Beginsituatie
     */
    private $beginsituatie;

    /**
     *
     * @var Lesplan\Introductie
     */
    private $introductie;

    /**
     *
     * @var Lesplan\Kern
     */
    private $kern;

    /**
     *
     * @var Lesplan\Afsluiting
     */
    private $afsluiting;

    public function __construct(string $opleiding, string $vak, string $les, Lesplan\Beginsituatie $beginsituatie, Lesplan\Introductie $introductie, Lesplan\Kern $kern, Lesplan\Afsluiting $afsluiting)
    {
        $this->opleiding = $opleiding;
        $this->vak = $vak;
        $this->les = $les;
        
        $this->beginsituatie = $beginsituatie;
        
        $this->introductie = $introductie;
        
        $this->kern = $kern;

        $this->afsluiting = $afsluiting;
        
    }

    /**
     * 
     * @param \Teach\Interactors\Web\Lesplan\Factory $factory
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface
    {
        return $factory->createLesplan($this->opleiding, $this->vak, $this->les, $this->beginsituatie->interact($factory), $this->introductie->interact($factory), $this->kern->interact($factory), $this->afsluiting->interact($factory));
    }
}