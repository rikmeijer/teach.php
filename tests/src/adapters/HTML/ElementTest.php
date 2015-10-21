<?php
namespace Teach\Adapters\HTML;

class ElementTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $object = new Element("table");
        $html = $object->render();
        $this->assertEquals('<table></table>', $html);
    }
}
