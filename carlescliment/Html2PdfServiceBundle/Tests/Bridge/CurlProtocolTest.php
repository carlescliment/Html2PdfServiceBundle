<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Bridge;

use carlescliment\Html2PdfServiceBundle\Bridge\CurlProtocol;

class CurlProtocolTest extends \PHPUnit_Framework_TestCase
{

    private $curl;
    private $protocol;
    private $response;

    public function setUp()
    {
        $this->curl = $this->getMock('shuber\Curl\Curl');
        $this->protocol = new CurlProtocol($this->curl);
        $this->protocol->setHost('http://remote.pdf.com');
        $this->response->headers['Status-Code'] = 200;
    }


    /**
     * @test
     */
    public function itDeletesTheRemoteDocumentToPreventConflicts()
    {
        $expected_url = 'http://remote.pdf.com/resource_name';
        $response = $this->responseMock(200);
        $this->stubCreateResponse(200);

        $this->curl->expects($this->once())
            ->method('delete')
            ->with($expected_url)
            ->will($this->returnValue($response));

        $this->protocol->create('', 'resource_name');
    }


    /**
     * @test
     * @expectedException carlescliment\Html2PdfServiceBundle\Exception\UnableToDeleteException
     */
    public function itThrowsAnExceptionIfTheResourceCouldNotBeDeleted()
    {
        $this->stubDeleteResponse(500);

        $this->protocol->create('', 'resource_name');
    }


    /**
     * @test
     */
    public function itCreatesTheRemoteDocument()
    {
        $this->allRequestsAreSuccessful();

        $this->curl->expects($this->once())
            ->method('put')
            ->with('http://remote.pdf.com/resource_name', array('content' => '<html></html>'));

        $this->protocol->create('<html></html>', 'resource_name');
    }


    /**
     * @test
     * @expectedException carlescliment\Html2PdfServiceBundle\Exception\UnableToCreateException
     */
    public function itThrowsAnExceptionIfTheResourceCouldNotBeCreated()
    {
        $this->stubDeleteResponse(200);
        $this->stubCreateResponse(500);

        $this->protocol->create('', 'resource_name');
    }


    /**
     * @test
     */
    public function itDisablesTheExpectHeaderInTheRequestToAllowUnwantedResponseHeaders()
    {
        $this->allRequestsAreSuccessful();

        $this->curl->expects($this->once())
            ->method('add_header')
            ->with('Expect', '');

        $this->protocol->create('', '');
    }


    /**
     * @test
     */
    public function itReturnsARemoteResourceInstance()
    {
        $this->allRequestsAreSuccessful();

        $resource = $this->protocol->create('', '');

        $this->assertInstanceOf('carlescliment\Html2PdfServiceBundle\Bridge\RemoteResource', $resource);
    }


    private function stubDeleteResponse($status_code)
    {
        $response = $this->responseMock($status_code);
        $this->curl->expects($this->any())
            ->method('delete')
            ->will($this->returnValue($response));
    }


    private function stubCreateResponse($status_code)
    {
        $response = $this->responseMock($status_code);
        $this->curl->expects($this->any())
            ->method('put')
            ->will($this->returnValue($response));
    }


    private function responseMock($status_code)
    {
        $response = $this->getMockBuilder('shuber\Curl\CurlResponse')
                    ->disableOriginalConstructor()
                    ->getMock();
        $response->headers['Status-Code'] = $status_code;
        return $response;
    }


    private function allRequestsAreSuccessful()
    {
        $this->stubDeleteResponse(200);
        $this->stubCreateResponse(200);
    }
}
