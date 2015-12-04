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
        $introductie = $factory->createIntroductie(
            $factory->createActiviteit("Activerende opening", $this->factory->getActiviteit($this->contactmoment['activerende_opening_id'])),
            $factory->createActiviteit("Focus", $this->factory->getActiviteit($this->contactmoment['focus_id'])),
            $factory->createActiviteit("Voorstellen", $this->factory->getActiviteit($this->contactmoment['voorstellen_id']))
        );
        
        $kernDefinition = $this->factory->getKern($this->contactmoment['lesplan_id']);
        $leerdoelen = array_keys($kernDefinition);
        $kern = $factory->createKern($kernDefinition);
        
        $beginsituatie = $factory->createBeginsituatie($this->contactmoment['opleiding'], [
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
        ]);
        $contactmoment = $factory->createContactmoment($this->contactmoment['les'], $beginsituatie, $this->factory->getMedia($this->contactmoment['lesplan_id']), $leerdoelen);
        
        $afsluiting = $factory->createFaseWithActiviteiten("Afsluiting", [
            "Huiswerk" => $this->factory->getActiviteit($this->contactmoment['huiswerk_id']),
            "Evaluatie" => $this->factory->getActiviteit($this->contactmoment['evaluatie_id']),
            "Pakkend slot" => $this->factory->getActiviteit($this->contactmoment['pakkend_slot_id'])
        ]);
        
        return $factory->createLesplan($this->contactmoment['vak'], $contactmoment, $introductie, $kern, $afsluiting);
    }
}