<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


abstract class Protocol implements ProtocolInterface
{

    protected $host;
    protected $port;

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

}