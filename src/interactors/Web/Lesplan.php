<?php
namespace Teach\Interactors\Web;

final class Lesplan implements \Teach\Interactors\PresentableInterface
{

    /**
     * 
     * @var string
     */
    private $opleiding;

    /**
     *
     * @var string
     */
    private $vak;

    /**
     *
     * @var string
     */
    private $les;
    
    /**
     * 
     * @var \Teach\Interactors\Web\Lesplan\Contactmoment
     */
    private $contactmoment;
    
    /**
     *
     * @var \Teach\Interactors\Web\Lesplan\Fase
     */
    private $introductie;
    
    
    /**
     * 
     * @var \Teach\Interactors\Web\Lesplan\Fase
     */
    private $kern;
    
    /**
     *
     * @var \Teach\Interactors\Web\Lesplan\Fase
     */
    private $afsluiting;
    
    public function __construct($opleiding, $vak, $les, Lesplan\Contactmoment $contactmoment, Lesplan\Fase $introductie, Lesplan\Fase $kern, Lesplan\Fase $afsluiting)
    {
        $this->opleiding = $opleiding;
        $this->vak = $vak;
        $this->les = $les;
        $this->contactmoment = $contactmoment;
        $this->introductie = $introductie;
        $this->kern = $kern;
        $this->afsluiting = $afsluiting;
    }

    public function present(\Teach\Adapters\AdapterInterface $adapter): string
    {
        $lines = [];
        $lines[] = $adapter->makeFirstPage('Lesplan ' . $this->vak, $this->opleiding)->render();
        
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader('2', $this->les));
        $lines[] = $section->render();
        
        $lines[] = $this->contactmoment->present($adapter);
        
        $lines[] = $this->introductie->present($adapter);
        $lines[] = $this->kern->present($adapter);
        $lines[] = $this->afsluiting->present($adapter);
        return join(PHP_EOL, $lines);
        
    }
}