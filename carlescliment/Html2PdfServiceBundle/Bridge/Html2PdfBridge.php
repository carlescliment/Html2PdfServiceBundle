<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;

use Symfony\Component\HttpFoundation\Response;

use carlescliment\Html2PdfServiceBundle\Protocol\ProtocolInterface;

class Html2PdfBridge
{

    private $protocol;

    public function __construct(ProtocolInterface $protocol)
    {
        $this->protocol = $protocol;
    }


    public function getFromHtml($html, $file_name)
    {
        $resource = $this->getResource($html, $file_name);
        return new Response;
    }


    private function getResource($html, $file_name)
    {
        return $this->protocol
                    ->create($html, $file_name)
                    ->get($file_name);
    }
}