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
}
