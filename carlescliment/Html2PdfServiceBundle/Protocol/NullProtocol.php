<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;

/**
 * For testing purposes
 */
class NullProtocol implements ProtocolInterface
{

    public function delete($resource_name)
    {
        return $this;
    }


    public function create($html, $resource_name)
    {
        return $this;
    }


    public function get($resource_name)
    {
        return '';
    }
}