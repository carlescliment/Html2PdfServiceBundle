<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;


/**
 *  http://php.net/manual/es/function.fopen.php
 *  fopen() accepts an url! :)
 */
class FileOpenProtocol extends Protocol
{

    public function getResource($resource)
    {
        \fopen($this->host);
        // ...
    }
}