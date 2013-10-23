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

    public function getFromHtml($html, $file_name)
    {
        $resource = $this->getResource($html);
        return new Response;
    }


    private function getResource($html)
    {
        return $this->protocol
                    ->setHost($this->host)
                    ->setPort($this->port)
                    ->getResource($html);
    }
}