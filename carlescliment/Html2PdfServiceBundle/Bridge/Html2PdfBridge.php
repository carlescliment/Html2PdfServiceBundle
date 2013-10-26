<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;

use Symfony\Component\HttpFoundation\Response;

use carlescliment\Html2PdfServiceBundle\Protocol\ProtocolInterface;
use carlescliment\Html2PdfServiceBundle\Response\PdfResponse;

class Html2PdfBridge
{

    private $protocol;

    public function __construct(ProtocolInterface $protocol)
    {
        $this->protocol = $protocol;
    }


    public function getFromHtml($html, $resource_name)
    {
        $contents = $this->getResource($html, $resource_name);
        return new PdfResponse($resource_name, $contents);
    }


    private function getResource($html, $resource_name)
    {
        return $this->protocol
                    ->delete($resource_name)
                    ->create($html, $resource_name)
                    ->get($resource_name);
    }
}