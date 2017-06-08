<?php
namespace Omnipay\Skeleton\Message;
/**
 * Authorize Request
 *
 * @method Response send()
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'card');
        $card = $this->getCard();

        $card->validate();

        $data = array(
            'transaction_id' => $this->getTransactionId(),
            'amount' => $this->getAmount(),
            'card' => array(
                'number' => $card->getNumber(),
                'expire_date' => $card->getExpiryDate('mY'),
                'cvv' => $card->getCvv()
            )
        );

        return $data;
    }
}
