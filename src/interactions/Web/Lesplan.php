<?php
namespace Teach\Interactions\Web;

final class Lesplan implements \Teach\Interactions\Documentable
{

    /**
     *
     * @var string
     */
    private $title;

    /**
     *
     * @var string
     */
    private $subtitle;

    /**
     *
     * @var string
     */
    private $les;

    /**
     *
     * @var \Teach\Interactions\Web\Lesplan\Contactmoment
     */
    private $contactmoment;

    /**
     *
     * @var \Teach\Interactions\Web\Lesplan\Fase
     */
    private $introductie;

    /**
     *
     * @var \Teach\Interactions\Web\Lesplan\Fase
     */
    private $kern;

    /**
     *
     * @var \Teach\Interactions\Web\Lesplan\Fase
     */
    private $afsluiting;

    public function __construct($subtitle, $title, $les, Lesplan\Contactmoment $contactmoment, Lesplan\Fase $introductie, Lesplan\Fase $kern, Lesplan\Fase $afsluiting)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        
        $this->les = $les;
        $this->contactmoment = $contactmoment;
        $this->introductie = $introductie;
        $this->kern = $kern;
        $this->afsluiting = $afsluiting;
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $lines = [];
        $lines[] = $adapter->makeFirstPage('Lesplan ' . $this->title, $this->subtitle)->render();
        
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader('2', $this->les));
        $lines[] = $section->render();
        $lines[] = $this->contactmoment->document($adapter);
        
        $lines[] = $this->introductie->document($adapter);
        $lines[] = $this->kern->document($adapter);
        $lines[] = $this->afsluiting->document($adapter);
        return join("", $lines);
    }
}