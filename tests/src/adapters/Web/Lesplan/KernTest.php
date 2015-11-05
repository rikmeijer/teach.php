<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class KernTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $object = new Kern(new Fase("Kern"));
        $object->addThema("Zelfstandig eclipse installeren", new Thema("Thema 1: Zelfstandig eclipse installeren"));
        
//         
// $object->
//             , 
//             "Java-code lezen en uitleggen wat er gebeurt" => new Lesplan\Thema("Thema 2: Java-code lezen en uitleggen wat er gebeurt")
//         ], new Lesplan\Fase("Afsluiting"));
        
        $html = $object->generateHTMLLayout();
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h2", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Kern", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
        $this->assertEquals('section', $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: Zelfstandig eclipse installeren", $html[0][HTMLFactory::CHILDREN][1][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
        
//         $this->assertEquals('section', $html[3][HTMLFactory::CHILDREN][2][HTMLFactory::TAG]);
//         $this->assertEquals("h3", $html[3][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
//         $this->assertEquals("Thema 2: Java-code lezen en uitleggen wat er gebeurt", $html[3][HTMLFactory::CHILDREN][2][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }
}
