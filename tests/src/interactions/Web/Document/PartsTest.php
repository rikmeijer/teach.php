<?php
namespace Teach\Interactions\Web\Document;

class PartsTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $object = new Parts(new \Teach\Interactions\Web\Lesplan\Fase('2', "Introductie"), new \Teach\Interactions\Web\Lesplan\Fase('2', "Kern"), new \Teach\Interactions\Web\Lesplan\Fase('2', "Afsluiting"));
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        $this->assertEquals('section2:Introductiesection2:Kernsection2:Afsluiting', $html);
    }
}
