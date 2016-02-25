<?php
namespace Teach\Adapters\HTML;

class FactoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Factory
     */
    private $object;

    protected function setUp()
    {
        $this->object = new Factory();
    }

    public function testRenderTemplate()
    {
        $template = tempnam(sys_get_temp_dir(), 'tpl');
        file_put_contents($template, '<?php return function (\Teach\Adapters\HTML\Factory $factory) { return "<a>Hello World</a>"; };');
        $html = $this->object->renderTemplate($template);
        $this->assertEquals('<a>Hello World</a>', $html);
    }

    public function testRenderTemplateWithParameters()
    {
        $template = tempnam(sys_get_temp_dir(), 'tpl');
        file_put_contents($template, '<?php return function (\Teach\Adapters\HTML\Factory $factory, $a, $b) { return "<$a>$b</$a>"; };');
        $html = $this->object->renderTemplate($template, "a", "Hello World");
        $this->assertEquals('<a>Hello World</a>', $html);
    }

    public function testmakeElement()
    {
        $element = $this->object->makeElement('a', []);
        $element->append($this->object->makeText('Hello World'));
        $html = $element->render();
        $this->assertEquals('<a>Hello World</a>', $html);
    }

    public function testmakeText()
    {
        $html = $this->object->makeText('Hello World')->render();
        $this->assertEquals('Hello World', $html);
    }

    public function testmakeElementWithMultipleChildren()
    {
        $element = $this->object->makeElement('a', []);
        $element->append($this->object->makeText('Hello World'), $this->object->makeElement('li', [
            'src' => "bla.gif"
        ]));
        $html = $element->render();
        $this->assertEquals('<a>Hello World<li src="bla.gif"></li></a>', $html);
    }

    public function testRenderTable()
    {
        $expectedHTML = '<table><caption>Activerende opening</caption><tr><th>inhoud</th><td id="inhoud">bladiebla</td><th>werkvorm</th><td id="werkvorm">bladiebla</td></tr><tr><th>inhoud</th><td id="inhoud" colspan="3"><ul><li>A</li><li>B</li><li>C</li></ul></td></tr></table>';
        $this->assertEquals($expectedHTML, $this->object->makeTable('Activerende opening', [
            [
                "inhoud" => "bladiebla",
                "werkvorm" => "bladiebla"
            ],
            [
                "inhoud" => [
                    'A',
                    'B',
                    'C'
                ]
            ]
        ])
            ->render());
    }

    public function testMakeTableNoCaption()
    {
        $html = $this->object->makeTable(null, [
            [
                "inhoud" => "bladiebla"
            ]
        ])->render();
        $this->assertEquals('<table><tr><th>inhoud</th><td id="inhoud">bladiebla</td></tr></table>', $html);
    }

    public function testMakeTableRow()
    {
        $html = $this->object->makeTableRow(2, [
            "inhoud" => "bladiebla"
        ])->render();
        $this->assertEquals('<tr><th>inhoud</th><td id="inhoud">bladiebla</td></tr>', $html);
    }

    public function testMakeTableRowWithUnorderedList()
    {
        $html = $this->object->makeTableRow(2, [
            "inhoud" => [
                'A',
                'B',
                'C'
            ]
        ])->render();
        $this->assertEquals('<tr><th>inhoud</th><td id="inhoud"><ul><li>A</li><li>B</li><li>C</li></ul></td></tr>', $html);
    }

    public function testMakeTableRowWithSpanningCell()
    {
        $html = $this->object->makeTableRow(4, [
            "inhoud" => "bladiebla"
        ])->render();
        $this->assertEquals('<tr><th>inhoud</th><td id="inhoud" colspan="3">bladiebla</td></tr>', $html);
    }

    public function testMakeUnorderedList()
    {
        $html = $this->object->makeUnorderedList([
            "A",
            "B",
            "C"
        ])->render();
        $expectedHTML = '<ul><li>A</li><li>B</li><li>C</li></ul>';
        $this->assertEquals($expectedHTML, $html);
    }

    public function testMakeHeader()
    {
        $this->assertEquals('<h3>HeaderHeader</h3>', $this->object->makeHeader('3', 'HeaderHeader')
            ->render());
    }
}
