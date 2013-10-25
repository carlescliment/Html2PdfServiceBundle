<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;

use shuber\Curl\CurlResponse;

class ResponseDecorator
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
        return $this->get('body');
    }

    public function get($field)
    {
        $data = json_decode($this->response->body);
        return isset($data->$field) ? $data->$field : null;
    }
}