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
     * @param array $variableIdentifiers
     * @return array
     */
    public function provideTemplateVariables(array $variableIdentifiers)
    {
        $variables = [];
        foreach ($variableIdentifiers as $variableIdentifier) {
            switch ($variableIdentifier) {
                case 'doelgroep':
                    $variables[$variableIdentifier] = [
                        'ervaring' => $this->beginsituatie['doelgroep']['ervaring'],
                        'beschrijving' => $this->beginsituatie['doelgroep']['beschrijving']
                    ];
                    break;
                case 'groepsgrootte':
                    $variables[$variableIdentifier] = $this->beginsituatie['doelgroep']['grootte'];
                    break;
                case 'tijd':
                    $variables[$variableIdentifier] = 'van ' . $this->beginsituatie['starttijd'] . ' tot ' . $this->beginsituatie['eindtijd'] . ' (' . $this->beginsituatie['duur'] . ' minuten)';
                    break;
                case 'ruimte':
                    $variables[$variableIdentifier] = $this->beginsituatie['ruimte'];
                    break;
                case 'overige':
                    $variables[$variableIdentifier] = $this->beginsituatie['overige'];
                    
                    break;
                case 'media':
                    $variables[$variableIdentifier] = $this->media;
                    
                    break;
                case 'leerdoelen':
                    $variables[$variableIdentifier] = $this->leerdoelen;
                    
                    break;
            }
        }
        return $variables;
    }
}