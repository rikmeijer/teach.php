<?php
namespace Teach\Adapters\HTML\Lesplan;

class FaseTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var Lesplan
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

    public function testRender()
    {
        $html = $this->object->render();
        $this->assertEquals('<table class="two-columns"></table>', $html);
    }
}
