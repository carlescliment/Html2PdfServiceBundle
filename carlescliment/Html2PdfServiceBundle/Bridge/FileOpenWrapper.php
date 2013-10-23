<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


/**
 *  http://php.net/manual/es/function.fopen.php
 *  fopen() accepts an url! :)
 */
class FileOpenWrapper implements ProtocolInterface
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