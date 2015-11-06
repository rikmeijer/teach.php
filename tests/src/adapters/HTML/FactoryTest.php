<?php
namespace Teach\Adapters\HTML;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateElement()
    {
        $object = new Factory();
        $html = $object->createElement('a', [], [
            'Hello World'
        ])->render();
        $this->assertEquals('<a>Hello World</a>', $html);
    }

    public function testCreateText()
    {
        $object = new Factory();
        $html = $object->createText('Hello World')->render();
        $this->assertEquals('Hello World', $html);
    }

    public function testCreateElementWithMultipleChildren()
    {
        $object = new Factory();
        $html = $object->createElement('a', [], [
            'Hello World',
            [
                'li',
                [
                    'src' => "bla.gif"
                ],
                []
            ]
        ])->render();
        $this->assertEquals('<a>Hello World<li src="bla.gif"></li></a>', $html);
    }

    public function testMakeHTML()
    {
        $object = new Factory();
        $html = $object->makeHTML([
            'Hello World',
            [
                'li',
                [
                    'src' => "bla.gif"
                ],
                []
            ]
        ]);
        $this->assertEquals('Hello World<li src="bla.gif"></li>', $html);
    }

    public function testMakeHTMLWithTextOnlyElement()
    {
        $object = new Factory();
        $html = $object->makeHTML([
            'Hello World',
            [
                'a',
                'Hello Hello'
            ]
        ]);
        $this->assertEquals('Hello World<a>Hello Hello</a>', $html);
    }
    

    public function testMakeHTMLFrom()
    {
        $mockbuilder = $this->getMockBuilder('\Teach\Adapters\HTML\LayoutableInterface');
        $mockbuilder->setMockClassName('DummyHTML');
        $mockbuilder->setMethods(array('generateHTMLLayout'));
        $mock = $mockbuilder->getMock();
        $mock->method('generateHTMLLayout')->willReturn([
            'Hello World',
            [
                'li',
                [
                    'src' => "bla.gif"
                ],
                []
            ]
        ]);
        
        $object = new Factory();
        $html = $object->makeHTMLFrom($mock);
        $this->assertEquals('Hello World<li src="bla.gif"></li>', $html);
    }
    
    public function testMakeTableRow()
    {
        $object = new Factory();
        $html = $object->makeTableRow();
        $this->assertEquals('tr', $html[Factory::TAG]);
        
    }
}
