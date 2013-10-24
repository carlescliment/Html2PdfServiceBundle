<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\CurlProtocol;


class CurlProtocolTest extends \PHPUnit_Framework_TestCase
{

    private $curl;
    private $protocol;

    public function setUp()
    {
        $this->curl = $this->getMock('shuber\Curl\Curl');
        $this->protocol = new CurlProtocol($this->curl);
    }


    /**
     * @test
     */
    public function itCreatesTheRemoteDocument()
    {
        $content = '<html></html>';
        $this->protocol->setHost('http://remote.pdf.com');
        $expected_arguments = array('content' => $content);
        $expected_url = 'http://remote.pdf.com/resource_name';

        $this->curl->expects($this->once())
            ->method('put')
            ->with($expected_url, $expected_arguments);

        $this->protocol->create($content, 'resource_name');
    }


    /**
     * @test
     */
    public function itDisablesTheExpectHeaderInTheRequest()
    {
        $this->curl->expects($this->once())
            ->method('add_header')
            ->with('Expect', '');

        $this->protocol->create('', '');
    }

}
