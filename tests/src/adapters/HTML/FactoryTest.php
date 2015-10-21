<?php
namespace Teach\Adapters\HTML;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateElement()
    {
        $object = new Factory();
        $html = $object->createElement('a', [], ['Hello World'])->render();
        $this->assertEquals('<a>Hello World</a>', $html);
    }
    
    
}
