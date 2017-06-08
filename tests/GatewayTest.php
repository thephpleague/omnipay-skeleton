<?php

namespace Omnipay\Skeleton\Test;

use League\Omnipay\Tests\GatewayTestCase;
use League\Omnipay\Common\CreditCard;

class GatewayTest extends GatewayTestCase
{
    /**
     * @var \Omnipay\Skeleton\Gateway
     */
    protected $gateway;

    /**
     * @var array
     */
    protected $options;

    public function setUp()
    {
        parent::setUp();

        $this->gateway = new \Omnipay\Skeleton\Gateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = array(
            'amount' => '10.00',
            'currency' => 'USD',
            'card' => $this->getValidCard(),
        );
    }

    public function testAuthorize()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1234', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
