<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;


use shuber\Curl\Curl,
    shuber\Curl\CurlResponse;
use carlescliment\Html2PdfServiceBundle\Exception as Exceptions;
use carlescliment\Html2PdfServiceBundle\Response\CurlResponseDecorator;


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
            throw new Exceptions\UnableToDeleteException($response->getBody());
        }
        return $this;
    }

    public function get($resource_name)
    {
        $response = $this->getRemoteDocumentOrThrowException($resource_name);
        return $response->getBody();
    }


    public function create($html, $resource_name, $options = array())
    {
        $response = $this->createRemoteDocument($html, $resource_name, $options);
        if (!$response->isSuccessful()) {
            throw new Exceptions\UnableToCreateException($response->getBody());
        }
        return $this;
    }


    private function getRemoteDocumentOrThrowException($resource_name)
    {
        $url = $this->resourceToUrl($resource_name);
        $response = $this->decorate($this->curl->get($url));
        if (!$response->isSuccessful()) {
            throw new Exceptions\UnableToGetException($response->getBody());
        }
        return $response;
    }


    private function deleteRemoteDocumentIfExists($resource_name)
    {
        $url = $this->resourceToUrl($resource_name);
        return $this->decorate($this->curl->delete($url));
    }

    private function createRemoteDocument($html, $resource_name, $options)
    {
        $this->disableExpectHeader();
        $url = $this->resourceToUrl($resource_name);
        $parameters = array_merge(array('content' => $html), $options);
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
        return new CurlResponseDecorator($response);
    }
}
