<?php
namespace Teach\Interactions\Web\Document;

class PartsTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $object = new Parts(new \Teach\Interactions\Web\Lesplan\Fase("Introductie", new Parts()), new \Teach\Interactions\Web\Lesplan\Fase("Kern", new Parts()), new \Teach\Interactions\Web\Lesplan\Fase("Afsluiting", new Parts()));
        $html = $object->document(\Test\Helper::implementDocumenter());
        $this->assertEquals('section2:Introductie...section2:Kern...section2:Afsluiting...', $html);
    }
}
