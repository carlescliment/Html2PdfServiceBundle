<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;

use Symfony\Component\HttpFoundation\Response;

class SimpleHtml2PdfBridge
{

    private $fopen;
    private $host;
    private $port;

    public function __construct(FileOpenWrapper $fopen, $host, $port)
    {
        $this->fopen = $fopen;
        $this->host = $host;
        $this->port = $port;
    }

    public function get($resource)
    {
        $resource = $this->getResource($resource);
        return new Response;
    }


    private function getResource($resource)
    {
        return $this->fopen
                    ->setHost($this->host)
                    ->setPort($this->port)
                    ->getResource($resource);
    }
}