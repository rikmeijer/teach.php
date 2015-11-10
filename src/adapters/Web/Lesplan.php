<?php
namespace Teach\Adapters\Web;

final class Lesplan implements \Teach\Adapters\LayoutableInterface
{

    private $vak;

    private $les;
    
    /**
     * 
     * @var \Teach\Adapters\Web\Lesplan\Beginsituatie
     */
    private $beginsituatie;
    
    /**
     * 
     * @var string[]
     */
    private $media;

    /**
     *
     * @var \Teach\Adapters\Web\Lesplan\Fase
     */
    private $introductie;

    /**
     *
     * @var string[]
     */
    private $leerdoelen;
    
    /**
     * 
     * @var \Teach\Adapters\Web\Lesplan\Fase
     */
    private $kern;
    
    /**
     *
     * @var \Teach\Adapters\Web\Lesplan\Fase
     */
    private $afsluiting;
    
    public function __construct($vak, $les, Lesplan\Beginsituatie $beginsituatie, array $media, array $leerdoelen, Lesplan\Fase $introductie, Lesplan\Fase $kern, Lesplan\Fase $aflsluiting)
    {
        $this->vak = $vak;
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->introductie = $introductie;
        $this->leerdoelen = $leerdoelen;
        $this->kern = $kern;
        $this->afsluiting = $aflsluiting;
    }

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Adapters\LayoutFactoryInterface $factory)
    {
        $beginsituatieHTMLLayout = $this->beginsituatie->generateLayout ($factory);
        if (count($this->media) > 0) {
            $beginsituatieHTMLLayout[] = $factory->makeHeader3('Benodigde media');
            $beginsituatieHTMLLayout[] = $factory->makeUnorderedList($this->media);
        }
        
        $beginsituatieHTMLLayout[] = $factory->makeHeader3('Leerdoelen');
        $beginsituatieHTMLLayout[] = $factory->makeParagraph('Na afloop van de les kan de student:');
        $beginsituatieHTMLLayout[] = $factory->makeOrderedList($this->leerdoelen);
        
        return array_merge([
            $factory->makePageHeader($factory->makeHeader1('Lesplan ' . $this->vak)),
            $factory->makeSection($factory->makeHeader2($this->les), $beginsituatieHTMLLayout)
        ], 
            $this->introductie->generateLayout ($factory),
            $this->kern->generateLayout ($factory),
            $this->afsluiting->generateLayout ($factory)
            );
    }
}