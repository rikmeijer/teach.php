<?php
namespace Teach\Interactions;

class DocumentTest extends \PHPUnit_Framework_TestCase
{

    public function testRender()
    {
        $object = new Document(\Test\Helper::implementDocumenter());
        
        $html = $object->render(new class() implements \Teach\Domain\Documentable {

            public function document(\Teach\Interactions\Documenter $adapter): string
            {
                return '<p>Hello World</p>';
            }
        });
        $this->assertEquals('<html><head></head><body><p>Hello World</p></body></html>', $html);
    }
}