<?php
namespace Teach\Entities;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-10-14 at 13:44:20.
 */
class ContactmomentTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateLesplan()
    {
        $object = new Contactmoment();
        $factory = new \Teach\Interactors\Web\Lesplan\Factory();
        $lesplanlayout = $object->createLesplan($factory);
        $this->assertInstanceOf('\Teach\Interactors\Web\Lesplan', $lesplanlayout);
    }
}
