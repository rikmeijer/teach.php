<?php
namespace Teach\Domain;

class Lesplan implements \Teach\Domain\Documentable
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

    public function document(\Teach\Domain\Documenter $documenter): string
    {
        $lines = [];
        $lines[] = $adapter->makeFirstPage("Lesplan " . $this->vak, $this->opleiding)->render();
        $lines[] = $this->beginsituatie->document($adapter);
        $lines[] = $this->introductie->document($adapter);
        $lines[] = $this->kern->document($adapter);
        $lines[] = $this->afsluiting->document($adapter);
        return $adapter->makeDocument("Lesplan " . $this->vak, join("", $lines))->render();
    }
}