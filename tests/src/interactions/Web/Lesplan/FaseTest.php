<?php
namespace Teach\Interactions\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{

    public function testDocument()
    {
        $parts = new \Teach\Interactions\Web\Document\Parts(new Fase('3', "Thema 1: zelf de motor reviseren", new \Teach\Interactions\Web\Document\Parts()));
        
        $object = new Fase("2", "Kern", $parts);
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        
        $this->assertEquals('section2:Kern...section3:Thema 1: zelf de motor reviseren...', $html);
    }
}
