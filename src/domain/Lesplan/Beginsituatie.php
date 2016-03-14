<?php
namespace Teach\Domain\Lesplan;

class Beginsituatie implements \Teach\Domain\Documentable
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

    public function document(\Teach\Domain\Documenter $documenter): string
    {
        $section = $documenter->makeSection();
        $section->append($documenter->makeHeader('2', $this->les));
        $section->append($documenter->makeHeader('3', 'Beginsituatie'), $documenter->makeTable(null, [
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
            $section->append($documenter->makeHeader('3', 'Media'), $documenter->makeUnorderedList($this->media));
        }
        
        $section->append($documenter->makeHeader('3', 'Leerdoelen'));
        $section->appendHTML('<p>Na afloop van de les kan de student:</p>');
        $section->append($documenter->makeUnorderedList($this->leerdoelen));
        
        return $section->render();
    }
}