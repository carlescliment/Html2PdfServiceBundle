<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Response;

use carlescliment\Html2PdfServiceBundle\Tests\MockerTestCase;
use carlescliment\Html2PdfServiceBundle\Response\ResponseDecorator;

class ResponseDecoratorTest extends MockerTestCase
{

    /**
     * @test
     */
    public function itBringsIfResponseIsSuccessful()
    {
        $successful_response = $this->createDecoratorFor(array('Status-Code' => 200));
        $failing_response = $this->createDecoratorFor(array('Status-Code' => 500));

        $this->assertTrue($successful_response->isSuccessful());
        $this->assertFalse($failing_response->isSuccessful());
    }


    /**
     * @test
     */
    public function itBringsIfResponseIsNotFound()
    {
        $successful_response = $this->createDecoratorFor(array('Status-Code' => 200));
        $not_found_response = $this->createDecoratorFor(array('Status-Code' => 404));

        $this->assertFalse($successful_response->isNotFound());
        $this->assertTrue($not_found_response->isNotFound());
    }


    /**
     * @test
     */
    public function itBringsIfResponseIsError()
    {
        $successful_response = $this->createDecoratorFor(array('Status-Code' => 200));
        $failing_response = $this->createDecoratorFor(array('Status-Code' => 500));

        $this->assertFalse($successful_response->isError());
        $this->assertTrue($failing_response->isError());
    }


    /**
     * @test
     */
    public function itBringsTheBody()
    {
        $decorator = $this->createDecoratorFor(array(), array('body' => 'hi!'));

        $value = $decorator->getBody();

        $this->assertEquals('hi!', $value);
    }


    /**
     * @test
     */
    public function itDecodesTheBodyIfEncodingIsNotified()
    {
        $decoded = 'Hi Joe!';
        $encoded = base64_encode($decoded);
        $decorator = $this->createDecoratorFor(array(), array('body' => $encoded, 'encoding' => 'base64'));

        $value = $decorator->getBody();

        $this->assertEquals($decoded, $value);
    }


    /**
     * @test
     */
    public function itBringsAnyJsonField()
    {
        $decorator = $this->createDecoratorFor(array(), array('some_field' => 'hi!'));

        $value = $decorator->get('some_field');

        $this->assertEquals('hi!', $value);
    }



    private function createDecoratorFor(array $headers, array $body = array())
    {
        $curl_response = $this->mock('shuber\Curl\CurlResponse');
        $curl_response->headers = $headers;
        $curl_response->body = json_encode($body);
        return new ResponseDecorator($curl_response);
    }
}