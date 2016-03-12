<?php
namespace Teach\Interactions\Web\Document;

class SectionTest extends \PHPUnit_Framework_TestCase
{

    public function testDocument()
    {
        $parts = new Parts(new Section("Thema 1: zelf de motor reviseren", new Parts()));
        
        $object = new Section("Kern", $parts);
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        
        $this->assertEquals('section2:Kern...section3:Thema 1: zelf de motor reviseren...', $html);
    }
}
