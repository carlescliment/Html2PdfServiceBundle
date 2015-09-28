<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\Html2PdfBridge;


class SimpleHtml2PdfBridgeTest extends \PHPUnit_Framework_TestCase
{

    private $bridge;
    private $protocol;

    public function setUp()
    {
        $this->protocol = $this->getMock('carlescliment\Html2PdfServiceBundle\Protocol\ProtocolInterface');
        $this->bridge = new Html2PdfBridge($this->protocol, 'http://localhost', '8085');
    }



    /**
     * @test
     */
    public function itDeletesTheResource()
    {
        $this->stubChainMethods(array('create'));

        $this->protocol->expects($this->once())
            ->method('delete')
            ->with('file_name')
            ->will($this->returnValue($this->protocol));

        $this->bridge->getFromHtml('<html></html>', 'file_name');
    }


    /**
     * @test
     */
    public function itCreatesTheResource()
    {
        $this->stubChainMethods(array('delete'));

        $this->protocol->expects($this->once())
            ->method('create')
            ->with('<html></html>', 'file_name', array('footer-left' => 'the footer'))
            ->will($this->returnValue($this->protocol));

        $this->bridge->getFromHtml('<html></html>', 'file_name', array('footer-left' => 'the footer'));
    }


    /**
     * @test
     */
    public function itRetrievesTheResource()
    {
        $this->stubChainMethods(array('delete', 'create'));

        $this->protocol->expects($this->once())
            ->method('get')
            ->with('file_name');

        $this->bridge->getFromHtml('<html></html>', 'file_name');
    }


    /**
     * @test
     */
    public function itBringsAResponse()
    {
        $this->stubChainMethods(array('delete', 'create'));

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
