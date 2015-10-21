<?php
namespace Teach\Adapters\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{
    public function testGenerateFirstStep()
    {
        $object = new Fase();
        $html = $object->generateFirstStep();
        $this->assertEquals('two-columns', $html['table'][0]['class']);
        $this->assertCount(0, $html['table'][1]);
    }
}
