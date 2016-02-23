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
    
    public function provideTemplateVariables(array $variableIdentifiers)
    {
        $variables = [];
        foreach ($variableIdentifiers as $variableIdentifier) {
            switch ($variableIdentifier) {
                case 'doelgroep':
                    $variables[$variableIdentifier] = $this->beginsituatie['doelgroep'];
                    break;
                case 'starttijd':
                    break;
                case 'eindtijd':
                    break;
                case 'duur':
                    break;
                case 'ruimte':
                    break;
                case 'overige':
                    break;
                case 'media':
                    break;
                case 'leerdoelen':
                    break;
            }
        }
        return $variables;
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