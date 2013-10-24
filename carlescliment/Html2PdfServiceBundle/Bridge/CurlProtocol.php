<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


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
        $response = $this->generateRemoteDocumentOrThrowException($html, $resource_name);
    }


    private function deleteRemoteDocumentOrThrowException($resource_name)
    {
        $response = $this->deleteRemoteDocumentIfExists($resource_name);
        if (!$response->isSuccessful()) {
            throw new UnableToDeleteException($response->getMessage());
        }
        return $response;
    }


    private function deleteRemoteDocumentIfExists($resource_name)
    {
        $url = $this->resourceToUrl($resource_name);
        return $this->decorate($this->curl->delete($url));
    }


    private function generateRemoteDocumentOrThrowException($html, $resource_name)
    {
        $response = $this->generateRemoteDocument($html, $resource_name);
        if (!$response->isSuccessful()) {
            throw new UnableToCreateException($response->getMessage());
        }
        return $response;
    }


    private function generateRemoteDocument($html, $resource_name)
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