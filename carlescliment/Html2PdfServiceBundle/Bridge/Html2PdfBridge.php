<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;

use Symfony\Component\HttpFoundation\Response;

class Html2PdfBridge
{

    private $protocol;
    private $host;
    private $port;

    public function __construct(ProtocolInterface $protocol, $host, $port)
    {
        $this->protocol = $protocol;
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
        return $this->protocol
                    ->setHost($this->host)
                    ->setPort($this->port)
                    ->getResource($resource);
    }
}