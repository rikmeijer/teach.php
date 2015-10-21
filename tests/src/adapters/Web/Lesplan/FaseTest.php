<?php
namespace Teach\Adapters\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFirstStep()
    {
        $object = new Fase("Beautiful caption");
        $html = $object->generateFirstStep();
        $this->assertEquals('two-columns', $html['table'][0]['class']);
        $this->assertEquals("Beautiful caption", $html['table'][1]['caption']);
    }
}
