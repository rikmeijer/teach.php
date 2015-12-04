<?php
namespace Teach\Interactors\Web;

final class Lesplan implements \Teach\Interactors\LayoutableInterface
{

    private $vak;
    
    /**
     * 
     * @var \Teach\Interactors\Web\Contactmoment
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
    
    public function __construct($vak, Contactmoment $contactmoment, Lesplan\Fase $introductie, Lesplan\Fase $kern, Lesplan\Fase $aflsluiting)
    {
        $this->vak = $vak;
        $this->contactmoment = $contactmoment;
        $this->introductie = $introductie;
        $this->kern = $kern;
        $this->afsluiting = $aflsluiting;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        return array_merge([
            $factory->makePageHeader($factory->makeHeader1('Lesplan ' . $this->vak)),
        ], 
            $this->contactmoment->generateLayout($factory),
            $this->introductie->generateLayout ($factory),
            $this->kern->generateLayout ($factory),
            $this->afsluiting->generateLayout ($factory)
            );
    }
}