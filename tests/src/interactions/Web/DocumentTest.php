<?php
namespace Teach\Interactions\Web;

class DocumentTest extends \PHPUnit_Framework_TestCase
{
    public function testDocument()
    {
        $parts = new DocumentParts(new Lesplan\Fase('2', "Introductie"), new Lesplan\Fase('2', "Kern"), new Lesplan\Fase('2', "Afsluiting"));
        
        $object = new Document("Lesplan Programmeren 1", "HBO-informatica (voltijd)", $parts);
        
        $html = $object->document(\Test\Helper::implementDocumenter());
        $this->assertEquals('fpLesplan Programmeren 1:HBO-informatica (voltijd)section2:Introductiesection2:Kernsection2:Afsluiting', $html);
    }
}
