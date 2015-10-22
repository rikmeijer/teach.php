<?php
namespace Teach\Adapters\Web\Lesplan;

use \Teach\Adapters\HTML\Factory as HTMLFactory;

class ThemaTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $object = new Thema("Thema 1: zelf de motor reviseren");
        $html = $object->generateHTMLLayout();
        $this->assertEquals('section', $html[0][HTMLFactory::TAG]);
        $this->assertEquals("h3", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TAG]);
        $this->assertEquals("Thema 1: zelf de motor reviseren", $html[0][HTMLFactory::CHILDREN][0][HTMLFactory::TEXT]);
    }
}
