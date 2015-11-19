<?php
namespace Teach\Entities;

class Contactmoment
{
    
    public function createLesplan(\Teach\Interactors\Web\Lesplan\Factory $factory)
    {
        return $factory->createLesplan([
            "opleiding" => "",
            "vak" => "",
            "les" => "",
            "Beginsituatie" => [],
            "media" => [],
            "Introductie" => [],
            "Kern" => [],
            "Afsluiting" => []
        ]);
    }
}