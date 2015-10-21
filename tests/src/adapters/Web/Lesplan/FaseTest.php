<?php
namespace Teach\Adapters\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFirstStep()
    {
        $object = new Fase("Beautiful caption");
        $html = $object->generateFirstStep();
        $this->assertEquals('table', $html[0][0]);
        $this->assertEquals('two-columns', $html[0][1]['class']);
        $this->assertEquals("caption", $html[0][2][0][0]);
        $this->assertEquals("Beautiful caption", $html[0][2][0][1]);

        $this->assertEquals("tr", $html[0][2][1][0]);
        $this->assertEquals("th", $html[0][2][1][2][0][0]);
        $this->assertEquals("werkvorm", $html[0][2][1][2][0][1]);
    }
}
