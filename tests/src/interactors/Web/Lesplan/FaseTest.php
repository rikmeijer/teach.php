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
    
    public function testGenerateHTMLLayout()
    {
        $object = new Fase("Kern");
        $html = $object->generateLayout (new HTMLFactory());
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }

    public function testGenerateHTMLLayoutOnderdelen()
    {
        $object = new Fase("Kern");
        
        $object->addOnderdeel(new Thema("Thema 1: zelf de motor reviseren"));
        $html = $object->generateLayout (new HTMLFactory());
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
        
        $this->assertEquals('section', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::CHILDREN][0]);
    }
}
