<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


interface ProtocolInterface
{

    public function setHost($host);

    public function setPort($port);

    public function getResource($resource);
}