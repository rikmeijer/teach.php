<?php
namespace Teach\Adapters\HTML;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testRenderTemplate()
    {
        $template = tempnam(sys_get_temp_dir(), 'tpl');
        file_put_contents($template, '<?php return function (\Teach\Adapters\HTML\Factory $factory) { return "<a>Hello World</a>"; };');
        $object = new Factory();
        $html = $object->renderTemplate($template);
        $this->assertEquals('<a>Hello World</a>', $html);
    }

    public function testRenderTemplateWithParameters()
    {
        $template = tempnam(sys_get_temp_dir(), 'tpl');
        file_put_contents($template, '<?php return function (\Teach\Adapters\HTML\Factory $factory, $a, $b) { return "<$a>$b</$a>"; };');
        $object = new Factory();
        $html = $object->renderTemplate($template, "a", "Hello World");
        $this->assertEquals('<a>Hello World</a>', $html);
    }

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
                'a', [], ['Hello Hello']
            ]
        ]);
        $this->assertEquals('Hello World<a>Hello Hello</a>', $html);
    }
    
    public function testRenderTable()
    {
        $object = new Factory();
        
        $expectedHTML = '<table><caption>Activerende opening</caption><tr><th>inhoud</th><td id="inhoud">bladiebla</td><th>werkvorm</th><td id="werkvorm">bladiebla</td></tr><tr><th>inhoud</th><td id="inhoud" colspan="3"><ul><li>A</li><li>B</li><li>C</li></ul></td></tr></table>';
        $this->assertEquals($expectedHTML, $object->makeTable('Activerende opening', [
            [
                "inhoud" => "bladiebla",
                "werkvorm" => "bladiebla"
            ],
            [
                "inhoud" => ['A', 'B', 'C']
            ]
        ])->render());
    }

    public function testRenderTableNoCaption()
    {
        $object = new Factory();
        $html = $object->makeTable(null, [
            [
                "inhoud" => "bladiebla"
            ]
        ])->render();
        $this->assertEquals('<table><tr><th>inhoud</th><td id="inhoud">bladiebla</td></tr></table>', $html);
    }

    public function testMakeTableRow()
    {
        $object = new Factory();
        $html = $object->makeTableRow(2, [
            "inhoud" => "bladiebla"
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][1][Factory::ATTRIBUTES]['id']);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0]);
    }

    public function testMakeTableRowWithPreparedChildren()
    {
        $object = new Factory();
        $html = $object->makeTableRow(2, [
            "inhoud" => [
                ['span', [], ["bladiebla"]]
            ]
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('span', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::CHILDREN][0]);
    }

    public function testMakeTableRowWithSpanningCell()
    {
        $object = new Factory();
        $html = $object->makeTableRow(4, [
            "inhoud" => "bladiebla"
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('3', $html[Factory::CHILDREN][1][Factory::ATTRIBUTES]['colspan']);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0]);
    }

    public function testMakeTableRowWithPreparedChildrenAndSpanningCell()
    {
        $object = new Factory();
        $html = $object->makeTableRow(4, [
            "inhoud" => [
                ['span', [], ["bladiebla"]]
            ]
        ]);
        $this->assertEquals('tr', $html[Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('3', $html[Factory::CHILDREN][1][Factory::ATTRIBUTES]['colspan']);
        $this->assertEquals('span', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::CHILDREN][0]);
    }
    
    public function testRenderUnorderedList()
    {
        $object = new Factory();
        $expectedHTML = '<ul><li>A</li><li>B</li><li>C</li></ul>';
        $this->assertEquals($expectedHTML, $object->renderUnorderedList([
            "A",
            "B",
            "C"
        ]));
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
        $this->assertEquals('A', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('li', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('B', $html[Factory::CHILDREN][1][Factory::CHILDREN][0]);
        $this->assertEquals('li', $html[Factory::CHILDREN][2][Factory::TAG]);
        $this->assertEquals('C', $html[Factory::CHILDREN][2][Factory::CHILDREN][0]);
    }

}
