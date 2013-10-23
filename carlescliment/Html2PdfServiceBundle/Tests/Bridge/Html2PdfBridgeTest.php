<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\Html2PdfBridge;


class SimpleHtml2PdfBridgeTest extends \PHPUnit_Framework_TestCase
{

    private $bridge;
    private $protocol;

    public function setUp()
    {
        $this->protocol = $this->getMock('carlescliment\Html2PdfServiceBundle\Bridge\ProtocolInterface');
        $this->bridge = new Html2PdfBridge($this->protocol, 'http://localhost', '8085');
    }


    /**
     * @test
     */
    public function itConfiguresTheHost()
    {
        $this->stubChainMethods(array('setPort'));

        $this->protocol->expects($this->once())
            ->method('setHost')
            ->with('http://localhost')
            ->will($this->returnValue($this->protocol));

        $this->bridge->getFromHtml('<html></html>', 'file_name');
    }


    /**
     * @test
     */
    public function itConfiguresThePort()
    {
        $this->stubChainMethods(array('setHost'));

        $this->protocol->expects($this->once())
            ->method('setPort')
            ->with('8085')
            ->will($this->returnValue($this->protocol));

        $this->bridge->getFromHtml('<html></html>', 'file_name');
    }


    /**
     * @test
     */
    public function itBringsTheResource()
    {
        $this->stubChainMethods(array('setHost', 'setPort'));

        $this->protocol->expects($this->once())
            ->method('create')
            ->with('<html></html>', 'file_name');

        $this->bridge->getFromHtml('<html></html>', 'file_name');
    }


    /**
     * @test
     */
    public function itBringsAResponse()
    {
        $this->stubChainMethods(array('setHost', 'setPort'));

        $response = $this->bridge->getFromHtml('<html></html>', 'file_name');

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
    }


    private function stubChainMethods(array $methods)
    {
        foreach ($methods as $method) {
            $this->protocol->expects($this->any())
                ->method($method)
                ->will($this->returnValue($this->protocol));
        }
    }
}
