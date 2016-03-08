<?php
namespace Teach\Domain;

class Lesplan implements \Teach\Interactors\InteractableInterface
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

    /**
     *
     * @return array
     */
    private function getBeginsituatie()
    {
        return [
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
        ];
    }

    /**
     * 
     * @param \Teach\Interactors\Web\Lesplan\Factory $factory
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface
    {
        $introductie = $this->factory->createIntroductie($this->contactmoment['activerende_opening_id'], $this->contactmoment['focus_id'], $this->contactmoment['voorstellen_id'], $this->contactmoment['kennismaken_id'], $this->contactmoment['terugblik_id']);
        
        $kern = $this->factory->createKern($this->contactmoment['lesplan_id']);
        
        $contactmoment = $this->factory->createContactmoment($this->getBeginsituatie(), $this->contactmoment['lesplan_id']);

        $afsluiting = $this->factory->createAfsluiting($this->contactmoment['huiswerk_id'], $this->contactmoment['evaluatie_id'], $this->contactmoment['pakkend_slot_id']);
        
        return $factory->createLesplan($this->contactmoment['opleiding'], $this->contactmoment['vak'], $this->contactmoment['les'], $contactmoment->interact($factory), $introductie->interact($factory), $kern->interact($factory), $afsluiting->interact($factory));
    }
}