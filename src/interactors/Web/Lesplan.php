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

    public function present(\Teach\Adapters\AdapterInterface $factory): string
    {
        $lines = [];
        $lines[] = $factory->renderTemplate("head.php");
        $lines[] = "<body>";
        $lines[] = $factory->renderTemplate("header.php", 'Lesplan ' . $this->vak, $this->opleiding);
        
        $section = $factory->makeSection();
        $section->append($factory->makeHeader('2', $this->les));
        $lines[] = $section->render();
        
        $lines[] = $this->contactmoment->present($factory);
        
        $lines[] = $this->introductie->present($factory);
        $lines[] = $this->kern->present($factory);
        $lines[] = $this->afsluiting->present($factory);
        
        $lines[] = "</body>";
        return join(PHP_EOL, $lines);
        
    }
}