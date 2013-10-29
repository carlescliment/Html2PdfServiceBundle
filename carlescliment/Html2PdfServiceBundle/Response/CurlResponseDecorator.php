<?php

namespace carlescliment\Html2PdfServiceBundle\Response;

use shuber\Curl\CurlResponse;

class CurlResponseDecorator
{


    private $response;

    public function __construct(CurlResponse $response)
    {
        $this->response = $response;
    }


    public function isSuccessful()
    {
        return $this->response->headers['Status-Code'] == '200';
    }


    public function isNotFound()
    {
        return $this->response->headers['Status-Code'] == '404';
    }


    public function isError()
    {
        return $this->response->headers['Status-Code'] == '500';
    }


    public function getBody()
    {
        $body = $this->get('body');
        $encoding = $this->get('encoding');
        return $encoding ? $this->decode($encoding, $body) : $body;
    }


    private function decode($encoding, $content)
    {
        if ($encoding == 'base64') {
            return base64_decode($content);
        }
        return $content;
    }

    public function get($field)
    {
        $data = json_decode($this->response->body);
        return isset($data->$field) ? $data->$field : null;
    }
}