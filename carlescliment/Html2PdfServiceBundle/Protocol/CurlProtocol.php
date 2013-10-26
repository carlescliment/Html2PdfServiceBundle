<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;


use shuber\Curl\Curl,
    shuber\Curl\CurlResponse;
use carlescliment\Html2PdfServiceBundle\Exception\UnableToDeleteException,
    carlescliment\Html2PdfServiceBundle\Exception\UnableToCreateException,
    carlescliment\Html2PdfServiceBundle\Exception\UnableToGetException;
use carlescliment\Html2PdfServiceBundle\Response\ResponseDecorator;


class CurlProtocol extends Protocol
{

    private $curl;

    public function __construct(Curl $curl, $host, $port = '80')
    {
        parent::__construct($host, $port);
        $this->curl = $curl;
    }


    public function delete($resource_name)
    {
        $response = $this->deleteRemoteDocumentIfExists($resource_name);
        if ($response->isError()) {
            throw new UnableToDeleteException($response->getBody());
        }
    }

    public function get($resource_name)
    {
        $response = $this->getRemoteDocumentOrThrowException($resource_name);
        return $response->getBody();
    }


    public function create($html, $resource_name)
    {
        $this->createRemoteDocumentOrThrowException($html, $resource_name);
        return $this;
    }


    private function getRemoteDocumentOrThrowException($resource_name)
    {
        $url = $this->resourceToUrl($resource_name);
        $response = $this->decorate($this->curl->get($url));
        if (!$response->isSuccessful()) {
            throw new UnableToGetException($response->getBody());
        }
        return $response;
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
            throw new UnableToCreateException($response->getBody());
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