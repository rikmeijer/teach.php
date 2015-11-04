<?php
namespace Teach\Adapters\HTML;

class DummyLayoutTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateHTMLLayout()
    {
        $object = new DummyLayout("Kern");
        $html = $object->generateHTMLLayout();
        $this->assertCount(0, $html);
    }
    
}
