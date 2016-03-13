<?php
namespace Teach\Domain\Lesplan;

class Thema implements \Teach\Interactions\Interactable
{

    /**
     *
     * @var string
     */
    private $title;

    /**
     *
     * @var Activiteit
     */
    private $ervaren;

    /**
     *
     * @var Activiteit
     */
    private $reflecteren;

    /**
     *
     * @var Activiteit
     */
    private $conceptualiseren;

    /**
     *
     * @var Activiteit
     */
    private $toepassen;

    public function __construct(string $title, Activiteit $ervaren, Activiteit $reflecteren, Activiteit $conceptualiseren, Activiteit $toepassen)
    {
        $this->title = $title;
        $this->ervaren = $ervaren;
        $this->reflecteren = $reflecteren;
        $this->conceptualiseren = $conceptualiseren;
        $this->toepassen = $toepassen;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Lesplan\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Lesplan\Factory $factory): \Teach\Interactions\Documentable
    {
        return $factory->createSection($this->title, $factory->createDocumentParts(
            $this->ervaren->interact($factory),
            $this->reflecteren->interact($factory),
            $this->conceptualiseren->interact($factory),
            $this->toepassen->interact($factory)
         ));
    }
}