<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\CurlHtml2PdfBridge;


class CurlHtml2PdfBridgeTest extends \PHPUnit_Framework_TestCase
{

    private $bridge;
    private $curl;

    public function setUp()
    {
        $this->curl = $this->getMock('carlescliment\Html2PdfServiceBundle\Bridge\CurlWrapper');
        $this->bridge = new CurlHtml2PdfBridge($this->curl, 'http://localhost', '8085');
    }


    /**
     * @test
     */
    public function itConfiguresTheHost()
    {
        $this->stubChainMethods(array('setPort'));

        $this->curl->expects($this->once())
            ->method('setHost')
            ->with('http://localhost')
            ->will($this->returnValue($this->curl));

        $this->bridge->get();
    }


    /**
     * @test
     */
    public function itConfiguresThePort()
    {
        $this->stubChainMethods(array('setHost'));

        $this->curl->expects($this->once())
            ->method('setPort')
            ->with('8085')
            ->will($this->returnValue($this->curl));

        $this->bridge->get();
    }


    /**
     * @test
     */
    public function itCreatesTheConnectionToTheHost()
    {
        $this->stubChainMethods(array('setHost', 'setPort'));

        $this->curl->expects($this->once())
            ->method('init');

        $this->bridge->get();
    }


    /**
     * @test
     */
    public function itBringsAResponse()
    {
        $this->stubChainMethods(array('setHost', 'setPort'));

        $response = $this->bridge->get();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
    }


    private function stubChainMethods(array $methods)
    {
        foreach ($methods as $method) {
            $this->curl->expects($this->any())
                ->method($method)
                ->will($this->returnValue($this->curl));
        }
    }
}