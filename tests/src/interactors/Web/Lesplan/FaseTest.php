<?php
namespace Teach\Interactors\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class FaseTest extends \PHPUnit_Framework_TestCase
{
    public function testProvideTemplateVariablesOnderdelen()
    {
        $object = new Fase("Kern");
        
        $object->addOnderdeel($onderdeel = new Thema("Thema 1: zelf de motor reviseren"));

        $variables = $object->provideTemplateVariables([
            "title",
            "onderdelen"
        ]);

        $this->assertEquals("Kern", $variables["title"]);
        $this->assertEquals($onderdeel, $variables["onderdelen"][0]);
    }
}
