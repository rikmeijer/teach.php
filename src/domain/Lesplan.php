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
     * @var Lesplan\Contactmoment
     */
    private $contactmoment;

    /**
     *
     * @var Lesplan\Introductie
     */
    private $introductie;

    /**
     *
     * @var Lesplan\Kern
     */
    private $kern;

    /**
     *
     * @var Lesplan\Afsluiting
     */
    private $afsluiting;

    public function __construct(Factory $factory, array $contactmoment)
    {
        $this->factory = $factory;
        
        $this->opleiding = $contactmoment['opleiding'];
        $this->vak = $contactmoment['vak'];
        $this->les = $contactmoment['les'];
        
        $this->introductie = $this->factory->createIntroductie($contactmoment['activerende_opening_id'], $contactmoment['focus_id'], $contactmoment['voorstellen_id'], $contactmoment['kennismaken_id'], $contactmoment['terugblik_id']);
        
        $this->kern = $this->factory->createKern($contactmoment['lesplan_id']);
        
        $this->contactmoment = $this->factory->createContactmoment([
            'doelgroep' => [
                'beschrijving' => $contactmoment['doelgroep_beschrijving'],
                'ervaring' => $contactmoment['doelgroep_ervaring'],
                'grootte' => $contactmoment['doelgroep_grootte'] . ' personen'
            ],
            'starttijd' => date('H:i', strtotime($contactmoment['starttijd'])),
            'eindtijd' => date('H:i', strtotime($contactmoment['eindtijd'])),
            'duur' => $contactmoment['duur'],
            'ruimte' => $contactmoment['ruimte'],
            'overige' => $contactmoment['opmerkingen']
        ], $contactmoment['lesplan_id']);

        $this->afsluiting = $this->factory->createAfsluiting($contactmoment['huiswerk_id'], $contactmoment['evaluatie_id'], $contactmoment['pakkend_slot_id']);
        
    }

    /**
     * 
     * @param \Teach\Interactors\Web\Lesplan\Factory $factory
     * @return \Teach\Interactors\LayoutableInterface
     */
    public function interact(\Teach\Interactors\Web\Lesplan\Factory $factory): \Teach\Interactors\LayoutableInterface
    {
        return $factory->createLesplan($this->opleiding, $this->vak, $this->les, $this->contactmoment->interact($factory), $this->introductie->interact($factory), $this->kern->interact($factory), $this->afsluiting->interact($factory));
    }
}