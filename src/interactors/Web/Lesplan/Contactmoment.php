<?php
namespace Teach\Interactors\Web\Lesplan;

final class Contactmoment implements \Teach\Interactors\PresentableInterface
{

    /**
     *
     * @var \Teach\Interactors\Web\Lesplan\Beginsituatie
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

    public function __construct(array $beginsituatie, array $media, array $leerdoelen)
    {
        $this->beginsituatie = $beginsituatie;
        $this->media = $media;
        $this->leerdoelen = $leerdoelen;
    }
    
    public function present(\Teach\Adapters\HTML\Factory $factory): string
    {
        $section = $factory->makeSection();
        $section->append($factory->makeHeader('3', 'Beginsituatie'), $factory->makeTable(null, [
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
            $section->append($factory->makeHeader('3', 'Media'), $factory->makeUnorderedList($this->media));
        }
        
        $section->append($factory->makeHeader('3', 'Leerdoelen'));
        $section->appendHTML('<p>Na afloop van de les kan de student:</p>');
        $section->append($factory->makeUnorderedList($this->leerdoelen));
        
        return $section->render();
    }
}