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
    
    public function __construct($vak, $les, Lesplan\Beginsituatie $beginsituatie, array $media, Lesplan\Fase $introductie, array $kernThemas, Lesplan\Fase $aflsluiting)
    {
        $this->vak = $vak;
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->introductie = $introductie;
        $this->leerdoelen = [];
        $kern = new Lesplan\Fase('Kern');
        foreach ($kernThemas as $themaIdentifier => $thema) {
            $this->leerdoelen[] = $themaIdentifier;
            $kern->addOnderdeel($thema);
        };
        $this->introductie->chainTo($kern);
        $kern->chainTo($aflsluiting);
    }

    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        $benodigdeMediaHTMLLayout = [];
        if (count($this->media) > 0) {
            $benodigdeMediaListItems = [];
            foreach ($this->media as $thema) {
                $benodigdeMediaListItems[] = [
                    'li',
                    $thema
                ];
            }
            
            $benodigdeMediaHTMLLayout[] = ['h3', 'Benodigde media'];
            $benodigdeMediaHTMLLayout[] = ['ul', [], $benodigdeMediaListItems];
        }
        
        $leerdoelenHTMLLayout = [
            ['h3', 'Leerdoelen'],
            ['p', 'Na afloop van de les kan de student:'],
            ['ol', [],[]]
        ];
        foreach ($this->leerdoelen as $leerdoel) {
            $leerdoelenHTMLLayout[2][2][] = ['li', $leerdoel];
        }
        
        return array_merge([
            [
                'header',
                [],
                [
                    [
                        'h1',
                        'Lesplan ' . $this->vak
                    ]
                ]
            ],
            [
                'section',
                [],
                array_merge([
                    [
                        'h2',
                        $this->les
                    ]
                ], $this->beginsituatie->generateHTMLLayout(), $benodigdeMediaHTMLLayout, $leerdoelenHTMLLayout)
            ],
            
        ], 
            $this->introductie->generateHTMLLayout()
            );
    }
}