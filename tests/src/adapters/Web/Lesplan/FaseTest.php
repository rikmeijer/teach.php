<?php
namespace Teach\Adapters\Web\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Fase
     */
    protected $object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new Fase();
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {}

    public function testGenerateFirstStep()
    {
        $html = $this->object->generateFirstStep();
        $this->assertEquals('two-columns', $html['table'][0]['class']);
        $this->assertCount(0, $html['table'][1]);
    }
}
