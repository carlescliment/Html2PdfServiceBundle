<?php

namespace carlescliment\Html2PdfServiceBundle\Protocol;


interface ProtocolInterface
{

    /**
     * @return ProtocolInterface itself
     */
    public function delete($resource_name);

    /**
     * @return ProtocolInterface itself
     */
    public function create($html, $resource_name, $options = array());

    /**
     * @return File contents
     */
    public function get($resource_name);
}
