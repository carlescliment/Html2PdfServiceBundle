<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Protocol;


use carlescliment\Html2PdfServiceBundle\Tests\MockerTestCase;
use carlescliment\Html2PdfServiceBundle\Protocol\CurlProtocol;

class CurlProtocolTest extends MockerTestCase
{

    private $curl;
    private $protocol;
    private $response;

    public function setUp()
    {
        $this->curl = $this->mock('shuber\Curl\Curl');
        $this->protocol = new CurlProtocol($this->curl, 'http://remote.pdf.com');
        $this->response->headers['Status-Code'] = 200;
    }


    /**
     * @test
     */
    public function itRequestsTheRemoteServerForAResource()
    {
        $this->stubGetResponse(200);

        $this->curl->expects($this->once())
            ->method('get')
            ->with('http://remote.pdf.com/resource_name');

        $this->protocol->get('resource_name');
    }


    /**
     * @test
     */
    public function itReturnsTheGivenResource()
    {
        $response = $this->stubGetResponse(200);
        $response->body = json_encode(array('body' => 'file contents'));

        $file_contents = $this->protocol->get('resource_name');

        $this->assertEquals('file contents', $file_contents);
    }


    /**
     * @test
     * @expectedException carlescliment\Html2PdfServiceBundle\Exception\UnableToGetException
     */
    public function itThrowsAnExceptionIfTheResourceCouldNotBeRetrieved()
    {
        $this->stubGetResponse(404);

        $this->protocol->get('resource_name');
    }


    /**
     * @test
     */
    public function itDeletesTheRemoteDocumentToPreventConflictsWhenCreating()
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
    public function itThrowsAnExceptionIfTheResourceCouldNotBeDeletedBeforeCreating()
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


    private function stubGetResponse($status_code)
    {
        return $this->stubResponseForMethod($status_code, 'get');
    }


    private function stubDeleteResponse($status_code)
    {
        return $this->stubResponseForMethod($status_code, 'delete');
    }


    private function stubCreateResponse($status_code)
    {
        return $this->stubResponseForMethod($status_code, 'put');
    }


    private function stubResponseForMethod($status_code, $method)
    {
        $response = $this->responseMock($status_code);
        $this->curl->expects($this->any())
            ->method($method)
            ->will($this->returnValue($response));
        return $response;
    }


    private function responseMock($status_code)
    {
        $response = $this->mock('shuber\Curl\CurlResponse');
        $response->headers['Status-Code'] = $status_code;
        $response->body = json_encode(array());
        return $response;
    }


    private function allRequestsAreSuccessful()
    {
        $this->stubDeleteResponse(200);
        $this->stubCreateResponse(200);
    }
}
