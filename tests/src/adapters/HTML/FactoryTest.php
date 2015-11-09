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
        $mockbuilder->setMethods(array(
            'generateHTMLLayout'
        ));
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
        $html = $object->makeTableRow(2, [
            "inhoud" => "bladiebla"
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::TEXT]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::TEXT]);
    }

    public function testMakeTableRowWithPreparedChildren()
    {
        $object = new Factory();
        $html = $object->makeTableRow(2, [
            "inhoud" => [
                [
                    'span',
                    "bladiebla"
                ]
            ]
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::TEXT]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('span', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TEXT]);
    }

    public function testMakeTableRowWithSpanningCell()
    {
        $object = new Factory();
        $html = $object->makeTableRow(4, [
            "inhoud" => "bladiebla"
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::TEXT]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('3', $html[Factory::CHILDREN][1][Factory::ATTRIBUTES]['colspan']);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0]);
    }

    public function testMakeTableRowWithPreparedChildrenAndSpanningCell()
    {
        $object = new Factory();
        $html = $object->makeTableRow(4, [
            "inhoud" => [
                [
                    'span',
                    "bladiebla"
                ]
            ]
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::TEXT]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('3', $html[Factory::CHILDREN][1][Factory::ATTRIBUTES]['colspan']);
        $this->assertEquals('span', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TEXT]);
    }

    public function testMakeUnorderedList()
    {
        $object = new Factory();
        $html = $object->makeUnorderedList([
            "A",
            "B",
            "C"
        ]);
        $this->assertEquals('ul', $html[Factory::TAG]);
        $this->assertEquals('li', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('A', $html[Factory::CHILDREN][0][Factory::TEXT]);
        $this->assertEquals('li', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('B', $html[Factory::CHILDREN][1][Factory::TEXT]);
        $this->assertEquals('li', $html[Factory::CHILDREN][2][Factory::TAG]);
        $this->assertEquals('C', $html[Factory::CHILDREN][2][Factory::TEXT]);
    }
}
