<?php

namespace carlescliment\Html2PdfServiceBundle\Bridge;



/**
 * set_time_limit(0);
 *
 * $url = 'http://www.freewarelovers.com/android/download/temp/1306495040_Number_Blink_1.1.1.apk';
 * $fp = fopen (dirname(__FILE__) . '/downloads/a.apk', 'w+');
 *
 *     $ch = curl_init($url);
 *
 *     curl_setopt_array($ch, array(
 *     CURLOPT_URL            => $url,
 *     CURLOPT_BINARYTRANSFER => 1,
 *     CURLOPT_RETURNTRANSFER => 1,
 *     CURLOPT_FILE           => $fp,
 *     CURLOPT_TIMEOUT        => 50,
 *     CURLOPT_USERAGENT      => 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)'
 *     ));
 *
 * $results = curl_exec($ch);
 * if(curl_exec($ch) === false)
 *  {
 *   echo 'Curl error: ' . curl_error($ch);
 *  }
 */
class CurlProtocol extends Protocol
{

    public function create($html, $resource_name)
    {
        $this->requestResourceGeneration();
        // ...
    }

    private function requestResourceGeneration($resource_name)
    {
        $channel = \curl_init($this->host . '/' . $resource_name);
        $temporary_file = fopen('php://temp/maxmemory:16000', 'w');
        \curl_setopt($channel, \CURLOPT_BINARYTRANSFER, 1);
        \curl_setopt($channel, \CURLOPT_RETURNTRANSFER, 1);
        \curl_setopt($channel, \CURLOPT_PUT, 1);
        \curl_setopt($channel, \CURLOPT_FILE, $temporary_file);
        return curl_exec($ch);
    }
}
