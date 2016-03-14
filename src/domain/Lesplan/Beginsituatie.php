<?php
namespace Teach\Domain\Lesplan;

class Beginsituatie implements \Teach\Interactions\Interactable, \Teach\Interactions\Documentable
{

    /**
     *
     * @var string
     */
    private $les;

    /**
     *
     * @var array
     */
    private $beginsituatie;

    /**
     *
     * @var array
     */
    private $media;

    /**
     *
     * @var array
     */
    private $leerdoelen;

    public function __construct(string $les, array $beginsituatie, array $media, array $leerdoelen)
    {
        $this->les = $les;
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->leerdoelen = $leerdoelen;
    }

    /**
     *
     * @param \Teach\Interactions\Web\Factory $factory            
     * @return \Teach\Interactions\Documentable
     */
    public function interact(\Teach\Interactions\Web\Factory $factory): \Teach\Interactions\Documentable
    {
        return new class($this->les, $this->beginsituatie, $this->media, $this->leerdoelen) implements \Teach\Interactions\Documentable {

            private $les;

            /**
             *
             * @var \Teach\Interactions\Web\Lesplan\Beginsituatie
             */
            private $beginsituatie;

            /**
             *
             * @var string[]
             */
            private $media;

            /**
             *
             * @var string[]
             */
            private $leerdoelen;

            public function __construct(string $les, array $beginsituatie, array $media, array $leerdoelen)
            {
                $this->les = $les;
                $this->beginsituatie = $beginsituatie;
                $this->media = $media;
                $this->leerdoelen = $leerdoelen;
            }

            public function document(\Teach\Interactions\Documenter $adapter): string
            {
                $section = $adapter->makeSection();
                $section->append($adapter->makeHeader('2', $this->les));
                $section->append($adapter->makeHeader('3', 'Beginsituatie'), $adapter->makeTable(null, [
                    [
                        'doelgroep' => $this->beginsituatie['doelgroep']['beschrijving'],
                        'ervaring' => $this->beginsituatie['doelgroep']['ervaring']
                    ],
                    [
                        'groepsgrootte' => $this->beginsituatie['doelgroep']['grootte']
                    ],
                    [
                        'tijd' => 'van ' . $this->beginsituatie['starttijd'] . ' tot ' . $this->beginsituatie['eindtijd'] . ' (' . $this->beginsituatie['duur'] . ' minuten)'
                    ],
                    [
                        'ruimte' => $this->beginsituatie['ruimte']
                    ],
                    [
                        'overige' => $this->beginsituatie['overige']
                    ]
                ]));
                
                if (count($this->media) > 0) {
                    $section->append($adapter->makeHeader('3', 'Media'), $adapter->makeUnorderedList($this->media));
                }
                
                $section->append($adapter->makeHeader('3', 'Leerdoelen'));
                $section->appendHTML('<p>Na afloop van de les kan de student:</p>');
                $section->append($adapter->makeUnorderedList($this->leerdoelen));
                
                return $section->render();
            }
        };
    }

    public function document(\Teach\Interactions\Documenter $adapter): string
    {
        $section = $adapter->makeSection();
        $section->append($adapter->makeHeader('2', $this->les));
        $section->append($adapter->makeHeader('3', 'Beginsituatie'), $adapter->makeTable(null, [
            [
                'doelgroep' => $this->beginsituatie['doelgroep']['beschrijving'],
                'ervaring' => $this->beginsituatie['doelgroep']['ervaring']
            ],
            [
                'groepsgrootte' => $this->beginsituatie['doelgroep']['grootte']
            ],
            [
                'tijd' => 'van ' . $this->beginsituatie['starttijd'] . ' tot ' . $this->beginsituatie['eindtijd'] . ' (' . $this->beginsituatie['duur'] . ' minuten)'
            ],
            [
                'ruimte' => $this->beginsituatie['ruimte']
            ],
            [
                'overige' => $this->beginsituatie['overige']
            ]
        ]));
        
        if (count($this->media) > 0) {
            $section->append($adapter->makeHeader('3', 'Media'), $adapter->makeUnorderedList($this->media));
        }
        
        $section->append($adapter->makeHeader('3', 'Leerdoelen'));
        $section->appendHTML('<p>Na afloop van de les kan de student:</p>');
        $section->append($adapter->makeUnorderedList($this->leerdoelen));
        
        return $section->render();
    }
}