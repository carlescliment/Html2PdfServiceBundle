<?php

namespace carlescliment\Html2PdfServiceBundle\Response;

use Symfony\Component\HttpFoundation\Response;

class PdfResponse extends Response
{

    private $fileName;


    public function __construct($file_name, $content)
    {
        parent::__construct($content);
        $this->fileName = $file_name;
    }

    public function sendContent()
    {
        $out = fopen('php://output', 'wb');
        fwrite($out, $this->content);
        fclose($out);
    }
}