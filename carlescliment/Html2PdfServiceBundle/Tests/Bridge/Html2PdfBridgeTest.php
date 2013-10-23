<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\Html2PdfBridge;


class Html2PdfBridgeTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @test
     */
    public function itCreatesAConnectionToTheHost()
    {
        $curl = $this->getMock('carlescliment\Html2PdfServiceBundle\Bridge\CurlWrapper');
        $bridge = new Html2PdfBridge($curl, 'http://localhost');

        $curl->expects($this->once())
            ->method('init')
            ->with('http://localhost');

        $bridge->get();
    }


    /**
     * @test
     */
    public function itBringsAResponse()
    {
        $curl = $this->getMock('carlescliment\Html2PdfServiceBundle\Bridge\CurlWrapper');
        $bridge = new Html2PdfBridge($curl, 'http://localhost');

        $response = $bridge->get();

        $this->assertInstanceOf('Symfony\Component\HttpFoundation\Response', $response);
    }
}