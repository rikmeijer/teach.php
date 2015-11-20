<?php
namespace Teach\Entities;

class Contactmoment
{

    /**
     *
     * @var array contactmoment record
     */
    private $contactmoment;

    public function __construct(Factory $factory, $identifier)
    {
        $contactmomenten = $factory->query("
            SELECT 
                'HBO-informatica (voltijd)' AS opleiding,
                les.id AS lesplan_id,
                les.naam AS les,
                module.naam AS vak,
                doelgroep.grootte AS doelgroep_grootte,
                doelgroep.ervaring AS doelgroep_ervaring,
                doelgroep.beschrijving AS doelgroep_beschrijving,
                contactmoment.starttijd AS starttijd,
                contactmoment.eindtijd AS eindtijd,
                SUM(activiteit.tijd) + (
                    SELECT SUM(activiteit.tijd) 
                    FROM thema 
                    LEFT JOIN activiteit ON activiteit.id IN (
                        thema.ervaren_id,
                        thema.reflecteren_id,
                        thema.conceptualiseren_id,
                        thema.toepassen_id
                    )
                    WHERE thema.les_id = les.id
                ) as duur,
                TIMESTAMPDIFF(MINUTE, contactmoment.starttijd, contactmoment.eindtijd) as beschikbaar,
                contactmoment.ruimte,
                les.opmerkingen,
                les.activerende_opening_id,
                les.focus_id,
                les.voorstellen_id,
                les.kennismaken_id,
                les.terugblik_id,
                les.huiswerk_id,
                les.evaluatie_id,
                les.pakkend_slot_id
            FROM contactmoment
            JOIN les ON les.id = contactmoment.les_id
            JOIN module ON module.id = les.module_id
            JOIN doelgroep ON doelgroep.id = les.doelgroep_id
            
            LEFT JOIN activiteit ON activiteit.id IN (
                les.activerende_opening_id,
                les.focus_id,
                les.voorstellen_id,
                les.kennismaken_id,
                les.terugblik_id,
                les.huiswerk_id,
                les.evaluatie_id,
                les.pakkend_slot_id
            )
            WHERE 
                contactmoment.id = " . $identifier . "
            GROUP BY
                contactmoment.id
        ");
        if (count($contactmomenten) == 0) {
            $this->contactmoment = $this->getDummy();
        } else {
            $this->contactmoment = $contactmomenten[0];
        }
    }

    private function getDummy()
    {
        return [
            "opleiding" => 'HBO-informatica (voltijd)',
            "lesplan_id" => "onbekend",
            "les" => "onbekend",
            "vak" => "onbekend",
            "doelgroep_grootte" => "onbekend",
            "doelgroep_ervaring" => "onbekend",
            "doelgroep_beschrijving" => "onbekend",
            "starttijd" => "onbekend",
            "eindtijd" => "onbekend",
            "duur" => "onbekend",
            "beschikbaar" => "onbekend",
            "ruimte" => "onbekend",
            "opmerkingen" => "",
            "activerende_opening_id" => null,
            "focus_id" => null,
            "voorstellen_id" => null,
            "kennismaken_id" => null,
            "terugblik_id" => null,
            "huiswerk_id" => null,
            "evaluatie_id" => null,
            "pakkend_slot_id" => null
        ];
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