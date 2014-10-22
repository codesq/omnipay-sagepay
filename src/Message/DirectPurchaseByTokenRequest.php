<?php

namespace Omnipay\SagePay\Message;

/**
 * Sage Pay Direct Authorize Request
 */
class DirectPurchaseByTokenRequest extends AbstractRequest
{
    protected $action = 'PAYMENT';

    protected function getBaseAuthorizeData()
    {
        $this->validate('amount', 'card', 'transactionId');
        $card = $this->getCard();

        $data = $this->getBaseData();
        $data['Description'] = $this->getDescription();
        $data['Amount'] = $this->getAmount();
        $data['Currency'] = $this->getCurrency();
        $data['VendorTxCode'] = $this->getTransactionId();
        $data['ClientIPAddress'] = $this->getClientIp();
        $data['ApplyAVSCV2'] = $this->getApplyAVSCV2() ?: 0;
        $data['Apply3DSecure'] = $this->getApply3DSecure() ?: 0;

        // billing details
        $data['BillingFirstnames'] = $card->getBillingFirstName();
        $data['BillingSurname'] = $card->getBillingLastName();
        $data['BillingAddress1'] = $card->getBillingAddress1();
        $data['BillingAddress2'] = $card->getBillingAddress2();
        $data['BillingCity'] = $card->getBillingCity();
        $data['BillingPostCode'] = $card->getBillingPostcode();
        $data['BillingState'] = $card->getBillingCountry() === 'US' ? $card->getBillingState() : '';
        $data['BillingCountry'] = $card->getBillingCountry();
        $data['BillingPhone'] = $card->getBillingPhone();

        // shipping details
        $data['DeliveryFirstnames'] = $card->getShippingFirstName();
        $data['DeliverySurname'] = $card->getShippingLastName();
        $data['DeliveryAddress1'] = $card->getShippingAddress1();
        $data['DeliveryAddress2'] = $card->getShippingAddress2();
        $data['DeliveryCity'] = $card->getShippingCity();
        $data['DeliveryPostCode'] = $card->getShippingPostcode();
        $data['DeliveryState'] = $card->getShippingCountry() === 'US' ? $card->getShippingState() : '';
        $data['DeliveryCountry'] = $card->getShippingCountry();
        $data['DeliveryPhone'] = $card->getShippingPhone();
        $data['CustomerEMail'] = $card->getEmail();

        return $data;
    }

    public function getData()
    {
        $data = $this->getBaseAuthorizeData();
        $data['Token'] = $this->getCardReference();
        $data['CV2'] = $this->getCard()->getCvv();
        $data['StoreToken'] = $this->getStoreCardToken() ?: 0;

        return $data;
    }

    public function getService()
    {
        return 'vspdirect-register';
    }
}
