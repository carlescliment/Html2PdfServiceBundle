<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;


interface ProtocolInterface
{
    public function create($html, $resource_name);

    public function get($resource_name);
}