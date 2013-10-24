<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


class RemoteResource
{

    private $location;

    public function __construct(ResponseDecorator $response)
    {
        $this->location = $response->get('resource_name');
    }
}