<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


use shuber\Curl\Curl;


class CurlProtocol extends Protocol
{

    private $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = $curl;
    }

    public function create($html, $resource_name)
    {
        $response = $this->requestResourceGeneration($html, $resource_name);
    }

    private function requestResourceGeneration($html, $resource_name)
    {
        $parameters = array(
            'content' => $html
            );
        $url = $this->host . '/' . $resource_name;
        return $this->curl->put($url, $parameters);
    }
}