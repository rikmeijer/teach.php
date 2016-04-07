<?php
namespace Teach\Domain;

class Factory
{

    /**
     *
     * @var \Teach\Interactions\Database
     */
    private $database;

    public function __construct(\Teach\Interactions\Database $database)
    {
        $this->database = $database;
    }

    /**
     *
     * @param string $identifier            
     * @return \Teach\Interactions\Interactable
     */
    public function createLesplan($identifier): \Teach\Domain\Lesplan
    {
        $contactmoment = $this->database->getBeginsituatie($identifier);
        
        $introductie = $this->createIntroductie($contactmoment['activerende_opening_id'], $contactmoment['focus_id'], $contactmoment['voorstellen_id'], $contactmoment['kennismaken_id'], $contactmoment['terugblik_id']);
        
        $kern = $this->createKern($contactmoment['lesplan_id']);
        
        $media = $this->database->getMedia($contactmoment['lesplan_id']);
        $leerdoelen = $this->database->getLeerdoelen($contactmoment['lesplan_id']);
        $beginsituatie = $this->createBeginsituatie($contactmoment['les'], [
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
        ], $media, $leerdoelen);
        
        $afsluiting = $this->createAfsluiting($contactmoment['huiswerk_id'], $contactmoment['evaluatie_id'], $contactmoment['pakkend_slot_id']);
        
        return new Lesplan($contactmoment['opleiding'], $contactmoment['vak'], $beginsituatie, $introductie, $kern, $afsluiting);
    }

    /**
     *
     * @param string $huiswerkIdentifier            
     * @param string $evaluatieIdentifier            
     * @param string $slotIdentifier            
     * @return \Teach\Interactions\Interactable
     */
    private function createAfsluiting(string $huiswerkIdentifier = null, string $evaluatieIdentifier = null, string $slotIdentifier = null): \Teach\Domain\Lesplan\Afsluiting
    {
        return new Lesplan\Afsluiting($this->createActiviteit("Huiswerk", $huiswerkIdentifier), $this->createActiviteit("Evaluatie", $evaluatieIdentifier), $this->createActiviteit("Pakkend slot", $slotIdentifier));
    }

    /**
     * 
     * @param string $les
     * @param array $beginsituatie
     * @param array $media
     * @param array $leerdoelen
     * @return \Teach\Interactions\Interactable
     */
    private function createBeginsituatie(string $les, array $beginsituatie, array $media, array $leerdoelen): \Teach\Domain\Lesplan\Beginsituatie
    {
        return new Lesplan\Beginsituatie($les, $beginsituatie, $media, $leerdoelen);
    }
    
    /**
     * 
     * @param string $title
     * @param string $identifier
     * @return \Teach\Interactions\Interactable
     */
    private function createActiviteit(string $title, string $identifier = null): \Teach\Domain\Lesplan\Activiteit
    {
        return new Lesplan\Activiteit($title, $this->database->getActiviteit($identifier));
    } 

    /**
     *
     * @param string $lesplanIdentifier            
     * @return \Teach\Interactions\Interactable
     */
    private function createKern(string $lesplanIdentifier): \Teach\Domain\Lesplan\Kern
    {
        return new Lesplan\Kern($this->database->getKern($lesplanIdentifier));
    }

    private function createIntroductie(string $openingIdentifier = null, string $focusIdentifier = null, string $voorstellenIdentifier = null, string $kennismakenIdentifier = null, string $terugblikIdentifier = null): \Teach\Domain\Lesplan\Introductie
    {
        return new Lesplan\Introductie($this->createActiviteit("Activerende opening", $openingIdentifier), $this->createActiviteit("Focus", $focusIdentifier), $this->createActiviteit("Voorstellen", $voorstellenIdentifier), $this->createActiviteit("Kennismaken", $kennismakenIdentifier), $this->createActiviteit("Terugblik", $terugblikIdentifier));
    }

}