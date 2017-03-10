<?php

namespace Omnipay\Skeleton\Test\Message;

use League\Omnipay\Common\CreditCard;
use League\Omnipay\Tests\TestCase;

class AuthorizeRequestTest extends TestCase
{
    /**
     * @var \Omnipay\Skeleton\Message\AuthorizeRequest
     */
    private $request;

    public function setUp()
    {
        parent::setUp();

        $this->request = new \Omnipay\Skeleton\Message\AuthorizeRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(
            array(
                'amount' => '10.00',
                'currency' => 'USD',
                'card' => $this->getValidCard(),
            )
        );
    }

    public function testGetData()
    {
        $card = new CreditCard($this->getValidCard());
        $card->setStartMonth(1);
        $card->setStartYear(2000);

        $this->request->setCard($card);
        $this->request->setTransactionId('abc123');

        $data = $this->request->getData();

        $this->assertSame('abc123', $data['transaction_id']);

        $this->assertSame($card->getNumber(), $data['card']['number']);
        $this->assertSame($card->getExpiryDate('mY'), $data['card']['expire_date']);
        $this->assertSame($card->getCvv(), $data['card']['cvv']);
    }
}
