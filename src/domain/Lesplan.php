<?php
namespace Teach\Domain;

class Lesplan implements \Teach\Interactions\Interactable, \Teach\Interactions\Documentable
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
     * @param \Teach\Interactions\Web\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Factory $factory): \Teach\Interactions\Documentable
    {
        $lesplanDocumentParts = $factory->createDocumentParts($this->beginsituatie->interact($factory), $this->introductie->interact($factory), $this->kern->interact($factory), $this->afsluiting->interact($factory));
        $lesplanDocument = $factory->createDocument("Lesplan " . $this->vak, $this->opleiding, $lesplanDocumentParts);
        return $lesplanDocument;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $lines = [];
        $lines[] = $adapter->makeFirstPage("Lesplan " . $this->vak, $this->opleiding)->render();
        $lines[] = $this->beginsituatie->document($adapter);
        $lines[] = $this->introductie->document($adapter);
        $lines[] = $this->kern->document($adapter);
        $lines[] = $this->afsluiting->document($adapter);
        return join("", $lines);
    }
}