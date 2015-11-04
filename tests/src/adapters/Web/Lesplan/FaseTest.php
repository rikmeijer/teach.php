<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class FaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $object = new Fase("Kern");
        $html = $object->generateHTMLLayout();
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }

    public function testGenerateHTMLLayoutOnderdelen()
    {
        $object = new Fase("Kern");
        
        $object->addOnderdeel(new Thema("Thema 1: zelf de motor reviseren"));
        $html = $object->generateHTMLLayout();
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
        $this->assertEquals('section', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }
}
