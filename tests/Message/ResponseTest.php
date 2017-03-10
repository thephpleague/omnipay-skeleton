<?php

namespace Omnipay\Skeleton\Test\Message;

use League\Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testConstruct()
    {
        // response should decode URL format data
        $response = new \Omnipay\Skeleton\Message\Response($this->getMockRequest(), array('example' => 'value', 'foo' => 'bar'));
        $this->assertEquals(array('example' => 'value', 'foo' => 'bar'), $response->getData());
    }

    public function testProPurchaseSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('AuthorizeSuccess.txt');

        $response = new \Omnipay\Skeleton\Message\Response($this->getMockRequest(), json_decode($httpResponse->getBody()->getContents(), true));

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1234', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
