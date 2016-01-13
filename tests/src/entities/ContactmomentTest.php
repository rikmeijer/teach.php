<?php
namespace Teach\Entities;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-10-14 at 13:44:20.
 */
class ContactmomentTest extends \Teach\EntitiesTest
{
    public function testCreateLesplan()
    {   
        $factory = new Factory(self::$pdo);
        $object = $factory->createContactmoment('1');
        $factory = new \Teach\Interactors\Web\Lesplan\Factory();
        $lesplanlayout = $object->createLesplan($factory);
        $this->assertInstanceOf('\Teach\Interactors\Web\Lesplan', $lesplanlayout);
    }
    
    public function testCreateLesplanWithoutVoorstellen()
    {
        $factory = new Factory(self::$pdo);
        $contactmoment = new Contactmoment($factory, [
        "opleiding" => 'HBO-informatica (voltijd)',
        "lesplan_id" => null,
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
        ]);
        

        $factory = new \Teach\Interactors\Web\Lesplan\Factory();
        $lesplanlayout = $contactmoment->createLesplan($factory);
        $this->assertInstanceOf('\Teach\Interactors\Web\Lesplan', $lesplanlayout);
    }
}
