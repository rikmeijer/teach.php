<?php
namespace Teach\Entities;

class Contactmoment
{
    /**
     * 
     * @var array contactmoment record
     */
    private $contactmoment;
    
    public function __construct(array $contactmoment)
    {
        $this->contactmoment = $contactmoment;
    }
    
    public function createLesplan(\Teach\Interactors\Web\Lesplan\Factory $factory)
    {
        return $factory->createLesplan([
            'opleiding' => $this->contactmoment['opleiding'],
            'vak' => $this->contactmoment['vak'],
            'les' => $this->contactmoment['les'],
            'Beginsituatie' => [
                'doelgroep' => [
                    'beschrijving' => $this->contactmoment['doelgroep_beschrijving'],
                    'ervaring' => $this->contactmoment['doelgroep_ervaring'],
                    'grootte' => $this->contactmoment['doelgroep_grootte'] . ' personen'
                ],
                'starttijd' => date('H:i', strtotime($this->contactmoment['starttijd'])),
                'eindtijd' => date('H:i', strtotime($this->contactmoment['eindtijd'])),
                'duur' => $this->contactmoment['duur'],
                'ruimte' => $this->contactmoment['ruimte'],
                'overige' => $this->contactmoment['opmerkingen']
            ],
            "media" => [],
            "Introductie" => [],
            "Kern" => [],
            "Afsluiting" => []
        ]);
    }
}