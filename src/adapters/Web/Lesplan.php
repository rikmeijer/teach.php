<?php
namespace Teach\Adapters\Web;

final class Lesplan implements \Teach\Adapters\HTML\LayoutableInterface
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
    public function generateHTMLLayout(\Teach\Adapters\HTML\Factory $factory)
    {
        $benodigdeMediaHTMLLayout = [];
        if (count($this->media) > 0) {
            $benodigdeMediaHTMLLayout[] = $factory->makeHeader3('Benodigde media');
            $benodigdeMediaHTMLLayout[] = $factory->makeUnorderedList($this->media);
        }
        
        $leerdoelenHTMLLayout = [
            $factory->makeHeader3('Leerdoelen'),
            ['p', 'Na afloop van de les kan de student:'],
            $factory->makeOrderedList($this->leerdoelen)
        ];
        
        return array_merge([
            [
                'header',
                [],
                [
                    $factory->makeHeader1('Lesplan ' . $this->vak)
                ]
            ],
            [
                'section',
                [],
                array_merge([
                    $factory->makeHeader2($this->les)
                ], $this->beginsituatie->generateHTMLLayout($factory), $benodigdeMediaHTMLLayout, $leerdoelenHTMLLayout)
            ],
            
        ], 
            $this->introductie->generateHTMLLayout($factory),
            $this->kern->generateHTMLLayout($factory),
            $this->afsluiting->generateHTMLLayout($factory)
            );
    }
}