<?php

namespace carlescliment\Html2PdfServiceBundle\Tests;


class MockerTestCase extends \PHPUnit_Framework_TestCase
{

    protected function mock($instance, array $stubs = array())
    {
        $mock = $this->getMockBuilder($instance)
            ->disableOriginalConstructor()
            ->getMock();
        foreach ($stubs as $method => $value)
        {
            $mock->expects($this->any())
                ->method($method)
                ->will($this->returnValue($value));
        }
        return $mock;
    }
}
