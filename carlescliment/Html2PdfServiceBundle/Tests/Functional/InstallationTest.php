<?php

namespace carlescliment\Html2PdfServiceBundle\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InstallationTest extends WebTestCase
{

    protected static function createKernel(array $options = array())
    {
        return new AppKernel('test', true);
    }

    /**
     * @test
     */
    public function itLoadsTheServiceInTheSymfonyContainer()
    {
        $client = self::createClient();
        $container = $client->getKernel()->getContainer();

        $service = $container->get('html2pdf.bridge');

        $this->assertInstanceOf('carlescliment\Html2PdfServiceBundle\Bridge\Html2PdfBridge', $service);
    }

}