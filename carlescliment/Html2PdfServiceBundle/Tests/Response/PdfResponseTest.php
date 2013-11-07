<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Response;

use carlescliment\Html2PdfServiceBundle\Tests\MockerTestCase;
use carlescliment\Html2PdfServiceBundle\Response\PdfResponse;

class PdfResponseTest extends MockerTestCase
{

    /**
     * @test
     */
    public function itSetsTheContentTypeToPdf()
    {
        $response = new PdfResponse('file_name', 'content');

        $headers = $response->headers;

        $this->assertEquals($headers->get('Content-Type'), 'application/pdf');
    }

    /**
     * @test
     */
    public function itSetsTheFileName()
    {
        $response = new PdfResponse('file_name', 'content');

        $headers = $response->headers;

        $this->assertEquals($headers->get('Content-Disposition'), 'filename=file_name');
    }
}