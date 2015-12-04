<?php
namespace Teach\Entities;

class Contactmoment
{

    /**
     * 
     * @var Factory
     */
    private $factory;
    
    /**
     *
     * @var array contactmoment record
     */
    private $contactmoment;

    public function __construct(Factory $factory, array $contactmoment)
    {
        $this->factory = $factory;
        $this->contactmoment = $contactmoment;
    }

    public function createLesplan(\Teach\Interactors\Web\Lesplan\Factory $factory)
    {
        $introductie = [
                "Activerende opening" => $this->factory->getActiviteit($this->contactmoment['activerende_opening_id']),
                "Focus" => $this->factory->getActiviteit($this->contactmoment['focus_id']),
        ];
        if ($this->contactmoment['voorstellen_id'] !== null) {
            $introductie["Voorstellen"] = $this->factory->getActiviteit($this->contactmoment['voorstellen_id']);
        }
        
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
            "media" => $this->factory->getMedia($this->contactmoment['lesplan_id']),
            'Introductie' => $introductie,
            'Kern' => $this->factory->getKern($this->contactmoment['lesplan_id']),
            'Afsluiting' => [
                "Huiswerk" => $this->factory->getActiviteit($this->contactmoment['huiswerk_id']),
                "Evaluatie" => $this->factory->getActiviteit($this->contactmoment['evaluatie_id']),
                "Pakkend slot" => $this->factory->getActiviteit($this->contactmoment['pakkend_slot_id'])
            ]
        ]);
    }
}