<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\Html2PdfBridge;


class Html2PdfBridgeTest extends \PHPUnit_Framework_TestCase
{

    private $bridge;
    private $curl;

    public function setUp()
    {
        $this->curl = $this->getMock('carlescliment\Html2PdfServiceBundle\Bridge\CurlWrapper');
        $this->bridge = new Html2PdfBridge($this->curl, 'http://localhost');
    }

    /**
     * @test
     */
    public function itConfiguresTheHost()
    {
        $this->curl->expects($this->once())
            ->method('setHost')
            ->with('http://localhost')
            ->will($this->returnValue($this->curl));

        $this->bridge->get();
    }


    /**
     * @test
     */
    public function itCreatesAConnectionToTheHost()
    {
        $this->stubChainMethods();

        $this->curl->expects($this->once())
            ->method('init');

        $this->bridge->get();
    }


    /**
     * @test
     */
    public function itBringsAResponse()
    {
        $this->stubChainMethods();

        $response = $this->bridge->get();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
    }


    private function stubChainMethods()
    {
        $this->curl->expects($this->any())
            ->method('setHost')
            ->will($this->returnValue($this->curl));
    }
}