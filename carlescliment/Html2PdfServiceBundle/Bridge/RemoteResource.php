<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


class RemoteResource
{

    private $response;

    public function __construct(ResponseDecorator $response)
    {
        $this->response = $response;
    }
}