<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;

use Symfony\Component\HttpFoundation\Response;

use carlescliment\Html2PdfServiceBundle\Protocol\ProtocolInterface;

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
        $resource = $this->getResource($html, $file_name);
        return new Response;
    }


    private function getResource($html, $file_name)
    {
        return $this->protocol
                    ->setHost($this->host)
                    ->setPort($this->port)
                    ->create($html, $file_name);
    }
}