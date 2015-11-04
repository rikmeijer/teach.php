<?php
namespace Teach\Adapters\Web;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class LesplanTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $object = new Lesplan("Programmeren 1", 'Blok 1 / Week 1 / Les 1');
        
        $html = $object->generateHTMLLayout();
        $this->assertEquals('header', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Lesplan Programmeren 1", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);

        $this->assertEquals('section', $html[1][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Blok 1 / Week 1 / Les 1", $html[1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }

//     public function testGenerateHTMLLayoutOnderdelen()
//     {
//         $object = new Fase("Kern");
        
//         $object->addOnderdeel(new Thema("Thema 1: zelf de motor reviseren"));
//         $html = $object->generateHTMLLayout();
//         $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
//         $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
//         $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
//         $this->assertEquals('section', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
//         $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
//         $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
//     }
}
