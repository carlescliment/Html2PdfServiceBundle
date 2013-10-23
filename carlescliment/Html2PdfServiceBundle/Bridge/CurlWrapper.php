<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


class CurlWrapper
{

    private $curlResource = null;

    public function init($host)
    {
        $this->curlResource = \curl_init($host);
    }
}