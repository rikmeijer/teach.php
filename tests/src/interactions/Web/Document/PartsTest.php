<?php
namespace Teach\Interactions\Web\Document;

class PartsTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $object = new Parts(new Section("Introductie", new Parts()), new Section("Kern", new Parts()), new Section("Afsluiting", new Parts()));
        $html = $object->document(\Test\Helper::implementDocumenter());
        $this->assertEquals('section2:Introductie...section2:Kern...section2:Afsluiting...', $html);
    }
}
