<?php

namespace Omnipay\SagePay\Message;

/**
 * Sage Pay Refund Request
 */
class DeleteCardTokenRequest extends AbstractRequest
{
    protected $action = 'REMOVETOKEN';

    public function getData()
    {
        $data = $this->getBaseData();
        $data['Token'] = $this->getCardToken();

        return $data;
    }
}
