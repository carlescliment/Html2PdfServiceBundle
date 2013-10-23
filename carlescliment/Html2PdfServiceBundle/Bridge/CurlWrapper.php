<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


class CurlWrapper
{

    private $curlResource;
    private $host;

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }

    public function init()
    {
        $this->curlResource = \curl_init($this->host);
    }
}