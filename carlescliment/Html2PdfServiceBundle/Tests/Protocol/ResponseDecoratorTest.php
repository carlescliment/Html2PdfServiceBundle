<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Protocol;

use carlescliment\Html2PdfServiceBundle\Tests\MockerTestCase;
use carlescliment\Html2PdfServiceBundle\Protocol\ResponseDecorator;

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

    private function createDecoratorFor(array $headers)
    {
        $curl_response = $this->mock('shuber\Curl\CurlResponse');
        $curl_response->headers = $headers;
        return new ResponseDecorator($curl_response);
    }
}