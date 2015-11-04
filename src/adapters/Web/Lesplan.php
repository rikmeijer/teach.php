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
    
    public function __construct($vak, $les, Lesplan\Beginsituatie $beginsituatie, array $media)
    {
        $this->vak = $vak;
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
    }

    /**
     *
     * @return array
     */
    public function generateHTMLLayout()
    {
        $benodigdeMediaListItems = [];
        foreach ($this->media as $benodigdMedium) {
            $benodigdeMediaListItems[] = [
                'li',
                $benodigdMedium
            ];
        }
        
        $benodigdeMediaHTMLLayout = [
            ['h3', 'Benodigde media'],
            ['ul', [], $benodigdeMediaListItems]
        ];
        
        $leerdoelenHTMLLayout = [
            ['h3', 'Leerdoelen'],
            ['p']
            
        ];
        
        return [
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
            ]
        ];
    }
}