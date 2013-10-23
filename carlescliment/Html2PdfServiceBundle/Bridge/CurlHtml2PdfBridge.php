<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;

use Symfony\Component\HttpFoundation\Response;

class CurlHtml2PdfBridge
{

    private $curl;
    private $host;
    private $port;

    public function __construct(CurlWrapper $curl, $host, $port)
    {
        $this->curl = $curl;
        $this->host = $host;
        $this->port = $port;
    }

    public function get($resource)
    {
        $resource = $this->getResource($resource);
        return new Response;
    }


    private function getResource($resource)
    {
        return $this->curl
                    ->setHost($this->host)
                    ->setPort($this->port)
                    ->getResource($resource);
    }

    /*
    set_time_limit(0);

    $url = 'http://www.freewarelovers.com/android/download/temp/1306495040_Number_Blink_1.1.1.apk';
    $fp = fopen (dirname(__FILE__) . '/downloads/a.apk', 'w+');

        $ch = curl_init($url);

        curl_setopt_array($ch, array(
        CURLOPT_URL            => $url,
        CURLOPT_BINARYTRANSFER => 1,
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_FILE           => $fp,
        CURLOPT_TIMEOUT        => 50,
        CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
        ));

    $results = curl_exec($ch);
    if(curl_exec($ch) === false)
     {
      echo 'Curl error: ' . curl_error($ch);
     }
     */


    /*
        http://php.net/manual/es/function.fopen.php
        fopen() accepts an url! :)
     */
}
