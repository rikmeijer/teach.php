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
        $expectedHTML = $object->makeHTML([$object->makeTable('Activerende opening', [
            [
                "inhoud" => "bladiebla",
                "werkvorm" => "bladiebla"
            ],
            [
                "inhoud" => [$object->makeUnorderedList(['A', 'B', 'C'])]
            ]
        ])]);
        
        $this->assertEquals($expectedHTML, $object->renderTable('Activerende opening', [
            [
                "inhoud" => "bladiebla",
                "werkvorm" => "bladiebla"
            ],
            [
                "inhoud" => ['A', 'B', 'C']
            ]
        ]));
    }

    public function testMakeTable()
    {
        $object = new Factory();
        $html = $object->makeTable('Activerende opening', [
            [
                "inhoud" => [
                    ['span', [], ["bladiebla"]]
                ],
                "werkvorm" => [
                    ['span', [], ["bladiebla"]]
                ]
            ],
            [
                "inhoud" => [
                    ['span', [], ["bladiebla"]]
                ]
            ]
        ]);
        $this->assertEquals('table', $html[Factory::TAG]);
        $this->assertEquals('caption', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('Activerende opening', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        
        $this->assertEquals('tr', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('th', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('inhoud', $html[Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('td', $html[Factory::CHILDREN][1][Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('span', $html[Factory::CHILDREN][1][Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('bladiebla', $html[Factory::CHILDREN][1][Factory::CHILDREN][1][Factory::CHILDREN][0][Factory::CHILDREN][0]);
        
        $this->assertEquals('3', $html[Factory::CHILDREN][2][Factory::CHILDREN][1][Factory::ATTRIBUTES]['colspan']);
    }

    public function testMakeTableNoCaption()
    {
        $object = new Factory();
        $html = $object->makeTable(null, [
            [
                "inhoud" => [
                    [
                        'span',
                        "bladiebla"
                    ]
                ]
            ]
        ]);
        $this->assertEquals('table', $html[Factory::TAG]);
        $this->assertEquals('tr', $html[Factory::CHILDREN][0][Factory::TAG]);
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
        $this->assertEquals($object->makeHTML([$object->makeUnorderedList([
            "A",
            "B",
            "C"
        ])]), $object->renderUnorderedList([
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

    public function testMakeOrderedList()
    {
        $object = new Factory();
        $html = $object->makeOrderedList([
            "A",
            "B",
            "C"
        ]);
        $this->assertEquals('ol', $html[Factory::TAG]);
        $this->assertEquals('li', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('A', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('li', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('B', $html[Factory::CHILDREN][1][Factory::CHILDREN][0]);
        $this->assertEquals('li', $html[Factory::CHILDREN][2][Factory::TAG]);
        $this->assertEquals('C', $html[Factory::CHILDREN][2][Factory::CHILDREN][0]);
    }

    public function testMakeHeader1()
    {
        $object = new Factory();
        $html = $object->makeHeader1('Title');
        $this->assertEquals('h1', $html[Factory::TAG]);
        $this->assertEquals('Title', $html[Factory::CHILDREN][0]);
    }

    public function testMakeHeader2()
    {
        $object = new Factory();
        $html = $object->makeHeader2('Title');
        $this->assertEquals('h2', $html[Factory::TAG]);
        $this->assertEquals('Title', $html[Factory::CHILDREN][0]);
    }

    public function testMakeHeader3()
    {
        $object = new Factory();
        $html = $object->makeHeader3('Title');
        $this->assertEquals('h3', $html[Factory::TAG]);
        $this->assertEquals('Title', $html[Factory::CHILDREN][0]);
    }
    
    public function testMakeParagraph()
    {
        $object = new Factory();
        $html = $object->makeParagraph('Title');
        $this->assertEquals('p', $html[Factory::TAG]);
        $this->assertEquals('Title', $html[Factory::CHILDREN][0]);
    }
    

    public function testMakePageHeader()
    {
        $object = new Factory();
        $html = $object->makePageHeader($object->makeHeader1('Title'), $object->makeHeader2('Subtitle'));
        $this->assertEquals('header', $html[Factory::TAG]);
        $this->assertEquals('h1', $html[Factory::CHILDREN][0][Factory::TAG]);
        $this->assertEquals('Title', $html[Factory::CHILDREN][0][Factory::CHILDREN][0]);
        $this->assertEquals('h2', $html[Factory::CHILDREN][1][Factory::TAG]);
        $this->assertEquals('Subtitle', $html[Factory::CHILDREN][1][Factory::CHILDREN][0]);
    }
}
