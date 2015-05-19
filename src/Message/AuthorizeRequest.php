<?php
namespace Omnipay\Skeleton\Message;
/**
 * Authorize Request
 */
class AuthorizeRequest extends AbstractRequest
{
    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();
        $data = $this->getBaseData();
        return $data;
    }
}
