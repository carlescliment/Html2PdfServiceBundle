<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;


use shuber\Curl\Curl,
    shuber\Curl\CurlResponse;
use carlescliment\Html2PdfServiceBundle\Exception\UnableToDeleteException,
    carlescliment\Html2PdfServiceBundle\Exception\UnableToCreateException;

class CurlProtocol extends Protocol
{

    private $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }


    public function create($html, $resource_name)
    {
        $this->deleteRemoteDocumentOrThrowException($resource_name);
        $this->createRemoteDocumentOrThrowException($html, $resource_name);
    }


    private function deleteRemoteDocumentOrThrowException($resource_name)
    {
        $response = $this->deleteRemoteDocumentIfExists($resource_name);
        if ($response->isError()) {
            throw new UnableToDeleteException($response->get('message'));
        }
    }


    private function deleteRemoteDocumentIfExists($resource_name)
    {
        $url = $this->resourceToUrl($resource_name);
        return $this->decorate($this->curl->delete($url));
    }


    private function createRemoteDocumentOrThrowException($html, $resource_name)
    {
        $response = $this->createRemoteDocument($html, $resource_name);
        if (!$response->isSuccessful()) {
            throw new UnableToCreateException($response->get('message'));
        }
    }


    private function createRemoteDocument($html, $resource_name)
    {
        $this->disableExpectHeader();
        $url = $this->resourceToUrl($resource_name);
        $parameters = array('content' => $html);
        return $this->decorate($this->curl->put($url, $parameters));
    }


    private function disableExpectHeader()
    {
        $this->curl->add_header('Expect', '');
    }


    private function resourceToUrl($resource_name)
    {
        return $this->host . '/' . $resource_name;
    }


    private function decorate(CurlResponse $response)
    {
        return new ResponseDecorator($response);
    }
}