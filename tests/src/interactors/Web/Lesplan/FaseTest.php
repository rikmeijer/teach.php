<?php
namespace Teach\Interactions\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{

    public function testDocument()
    {
        $object = new Fase("Kern");
        
        $object->addOnderdeel($onderdeel = new Thema("Thema 1: zelf de motor reviseren"));
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        
        $this->assertEquals('section2:Kern...section3:Thema 1: zelf de motor reviseren', $html);
    }
}
