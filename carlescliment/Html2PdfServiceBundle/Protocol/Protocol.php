<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;


abstract class Protocol implements ProtocolInterface
{

    protected $host;
    protected $port;

    public function __construct($host, $port)
    {
        $this->host = $host;
        $this->port = $port;
    }

}