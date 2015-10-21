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

    public function testRenderAttributes()
    {
        $object = new Element("table");
        $object->attribute("class", "twin-cell");
        $html = $object->render();
        $this->assertEquals('<table class="twin-cell"></table>', $html);
    }


    public function testRenderChild()
    {
        $object = new Element("table");
        $object->append(new Element("tr"));
        $html = $object->render();
        $this->assertEquals('<table><tr></tr></table>', $html);
    }

    public function testRenderTextChild()
    {
        $object = new Element("table");
        $object->append(new Text("tr"));
        $html = $object->render();
        $this->assertEquals('<table>tr</table>', $html);
    }
    
    public function testRenderVoid()
    {
        $voids = ['br', 'hr', 'img', 'input', 'link', 'meta', 'area', 'base', 'col', 'embed', 'keygen', 'menuitem', 'param', 'source', 'track', 'wbr'];
        foreach ($voids as $void) {
            $object = new Element($void);
            $html = $object->render();
            $this->assertEquals('<' . $void . '>', $html);
        }
    }
}
