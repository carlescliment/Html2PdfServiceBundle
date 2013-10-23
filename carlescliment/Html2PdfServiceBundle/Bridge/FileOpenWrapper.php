<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


class FileOpenWrapper
{

    private $host;
    private $port;

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }


    public function setPort($port)
    {
        $this->port = $port;
        return $this;
    }


    public function getResource($resource)
    {
        \fopen($this->host);
        // ...
    }
}