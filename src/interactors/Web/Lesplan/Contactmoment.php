<?php
namespace Teach\Interactors\Web\Lesplan;

final class Contactmoment implements \Teach\Interactors\LayoutableInterface
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

    /**
     *
     * @return array
     */
    public function generateLayout (\Teach\Interactors\LayoutFactoryInterface $factory)
    {
        $beginsituatieHTMLLayout = [
            $factory->makeHeader3('Beginsituatie'),
            $factory->makeTable(null, [
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
            ])
        ];
        if (count($this->media) > 0) {
            $beginsituatieHTMLLayout[] = $factory->makeHeader3('Benodigde media');
            $beginsituatieHTMLLayout[] = $factory->makeUnorderedList($this->media);
        }
            
        $beginsituatieHTMLLayout[] = $factory->makeHeader3('Leerdoelen');
        $beginsituatieHTMLLayout[] = $factory->makeParagraph('Na afloop van de les kan de student:');
        $beginsituatieHTMLLayout[] = $factory->makeOrderedList($this->leerdoelen);
        
        return $beginsituatieHTMLLayout;
    }
}