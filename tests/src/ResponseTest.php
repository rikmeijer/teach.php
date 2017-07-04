<?php
/**
 * User: hameijer
 * Date: 21-3-17
 * Time: 12:56
 */

namespace rikmeijer\Teach;


class ResponseTest extends \PHPUnit_Framework_TestCase
{

    public function testMake_When_StatusAndBodySupplied_Expect_PSRResponseWithStatusAndBody() {

        $object = new Response();
        $response = $object->make(200, 'HelloWorld');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('HelloWorld', $response->getBody());
    }

    public function testMake_When_StatusAndBodyAndHeaderSupplied_Expect_PSRResponseWithStatusAndBodyAndHeader() {

        $object = new Response();
        $response = $object->makeWithHeaders(200, ['X-TEST' => 'Foobar'], 'HelloWorld');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('HelloWorld', $response->getBody());
        $this->assertEquals('Foobar', $response->getHeader('X-TEST')[0]);
    }

}
