<?php
namespace Teach\Adapters\HTML;

class TextTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $object = new Text("table");
        $html = $object->render();
        $this->assertEquals('table', $html);
    }

}
