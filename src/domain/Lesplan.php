<?php
namespace Teach\Domain;

class Lesplan implements \Teach\Interactions\Interactable
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

    public function __construct(string $opleiding, string $vak, Lesplan\Beginsituatie $beginsituatie, Lesplan\Introductie $introductie, Lesplan\Kern $kern, Lesplan\Afsluiting $afsluiting)
    {
        $this->opleiding = $opleiding;
        $this->vak = $vak;
        
        $this->beginsituatie = $beginsituatie;
        
        $this->introductie = $introductie;
        
        $this->kern = $kern;
        
        $this->afsluiting = $afsluiting;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        $lesplanDocument = $factory->createLesplan("Lesplan " . $this->vak, $this->opleiding);
        $lesplanDocument->addOnderdeel($this->beginsituatie->interact($factory));
        $lesplanDocument->addOnderdeel($this->introductie->interact($factory));
        $lesplanDocument->addOnderdeel($this->kern->interact($factory));
        $lesplanDocument->addOnderdeel($this->afsluiting->interact($factory));
        return $lesplanDocument;
    }
}