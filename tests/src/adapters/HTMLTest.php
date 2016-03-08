<?php
namespace Teach\Adapters;

class HTMLTest extends \PHPUnit_Framework_TestCase
{
    public function testRender()
    {
        $object = new HTML(new \Teach\Adapters\HTML\Factory(__DIR__));
        $html = $object->render(new class implements \Teach\Interactors\PresentableInterface {
            public function present(\Teach\Adapters\AdapterInterface $factory): string
            {
                return '<body></body>';
            }
        });
        $this->assertEquals('<!DOCTYPE html><html><body></body></html>', $html);
    }
    
    
}