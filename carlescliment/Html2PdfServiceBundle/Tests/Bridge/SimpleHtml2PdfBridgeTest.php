<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\SimpleHtml2PdfBridge;


class SimpleHtml2PdfBridgeTest extends \PHPUnit_Framework_TestCase
{

    private $bridge;
    private $fopen;

    public function setUp()
    {
        $this->fopen = $this->getMock('carlescliment\Html2PdfServiceBundle\Bridge\FileOpenWrapper');
        $this->bridge = new SimpleHtml2PdfBridge($this->fopen, 'http://localhost', '8085');
    }


    /**
     * @test
     */
    public function itConfiguresTheHost()
    {
        $this->stubChainMethods(array('setPort'));

        $this->fopen->expects($this->once())
            ->method('setHost')
            ->with('http://localhost')
            ->will($this->returnValue($this->fopen));

        $this->bridge->get('resource_name');
    }


    /**
     * @test
     */
    public function itConfiguresThePort()
    {
        $this->stubChainMethods(array('setHost'));

        $this->fopen->expects($this->once())
            ->method('setPort')
            ->with('8085')
            ->will($this->returnValue($this->fopen));

        $this->bridge->get('resource_name');
    }


    /**
     * @test
     */
    public function itBringsTheResource()
    {
        $this->stubChainMethods(array('setHost', 'setPort'));

        $this->fopen->expects($this->once())
            ->method('getResource')
            ->with('resource_name');

        $this->bridge->get('resource_name');
    }


    /**
     * @test
     */
    public function itBringsAResponse()
    {
        $this->stubChainMethods(array('setHost', 'setPort'));

        $response = $this->bridge->get('resource_name');

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
    }


    private function stubChainMethods(array $methods)
    {
        foreach ($methods as $method) {
            $this->fopen->expects($this->any())
                ->method($method)
                ->will($this->returnValue($this->fopen));
        }
    }
}
