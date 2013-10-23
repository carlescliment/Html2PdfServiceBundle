<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


class CurlWrapper
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


    public function init()
    {
        return \curl_init($this->host);
    }
}