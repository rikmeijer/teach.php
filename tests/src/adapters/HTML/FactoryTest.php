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
        $this->object = new Factory(sys_get_temp_dir());
    }

    public function testRenderTemplate()
    {
        $template = tempnam(sys_get_temp_dir(), 'tpl');
        file_put_contents($template, '<?php return function (\Teach\Adapters\HTML\Factory $factory) { return "<a>Hello World</a>"; };');

        $this->assertEquals('<a>Hello World</a>', $this->object->renderTemplate(basename($template)));
    }

    public function testRenderTemplateWithParameters()
    {
        $template = tempnam(sys_get_temp_dir(), 'tpl');
        file_put_contents($template, '<?php return function (\Teach\Adapters\HTML\Factory $factory, $a, $b) { return "<$a>$b</$a>"; };');

        $this->assertEquals('<a>Hello World</a>', $this->object->renderTemplate(basename($template), "a", "Hello World"));
    }

    public function testmakeElement()
    {
        $element = $this->object->makeElement('a', []);
        $element->append($this->object->makeText('Hello World'));

        $this->assertEquals('<a>Hello World</a>', $element->render());
    }

    public function testmakeText()
    {
        $this->assertEquals('Hello World', $this->object->makeText('Hello World')->render());
    }

    public function testmakeElementWithMultipleChildren()
    {
        $element = $this->object->makeElement('a', []);
        $element->append($this->object->makeText('Hello World'), $this->object->makeElement('li', [
            'src' => "bla.gif"
        ]));
        
        $this->assertEquals('<a>Hello World<li src="bla.gif"></li></a>', $element->render());
    }

    public function testRenderTable()
    {
        $this->assertEquals('<table><caption>Activerende opening</caption><tr><th>inhoud</th><td id="inhoud">bladiebla</td><th>werkvorm</th><td id="werkvorm">bladiebla</td></tr><tr><th>inhoud</th><td id="inhoud" colspan="3"><ul><li>A</li><li>B</li><li>C</li></ul></td></tr></table>', $this->object->makeTable('Activerende opening', [
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
        ])->render());
    }

    public function testMakeTableNoCaption()
    {
        $this->assertEquals('<table><tr><th>inhoud</th><td id="inhoud">bladiebla</td></tr></table>', $this->object->makeTable(null, [
            [
                "inhoud" => "bladiebla"
            ]
        ])->render());
    }

    public function testMakeTableRow()
    {
        $this->assertEquals('<tr><th>inhoud</th><td id="inhoud">bladiebla</td></tr>', $this->object->makeTableRow(2, [
            "inhoud" => "bladiebla"
        ])->render());
    }

    public function testMakeTableRowWithUnorderedList()
    {
        $this->assertEquals('<tr><th>inhoud</th><td id="inhoud"><ul><li>A</li><li>B</li><li>C</li></ul></td></tr>', $this->object->makeTableRow(2, [
            "inhoud" => [
                'A',
                'B',
                'C'
            ]
        ])->render());
    }

    public function testMakeTableRowWithSpanningCell()
    {
        $this->assertEquals('<tr><th>inhoud</th><td id="inhoud" colspan="3">bladiebla</td></tr>', $this->object->makeTableRow(4, [
            "inhoud" => "bladiebla"
        ])->render());
    }

    public function testMakeUnorderedList()
    {
        $this->assertEquals('<ul><li>A</li><li>B</li><li>C</li></ul>', $this->object->makeUnorderedList([
            "A",
            "B",
            "C"
        ])->render());
    }

    public function testMakeHeader()
    {
        $this->assertEquals('<h3>HeaderHeader</h3>', $this->object->makeHeader('3', 'HeaderHeader')->render());
    }
    
    public function testMakeSection()
    {
        $this->assertEquals('<section></section>', $this->object->makeSection()->render());
    }
}
