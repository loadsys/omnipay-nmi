<?php

namespace Omnipay\NMI\Message;

/**
* NMI Direct Post Create Card Request
*/
class DirectPostCreateCardRequest extends AbstractRequest
{
    protected $customer_vault = 'add_customer';

    public function getData()
    {
		$this->validate('card');
        $data = $this->getBaseData();

		if ($paymentToken = $this->getPaymentToken()) {
			$data['payment_token'] = $paymentToken;
		} else {
			$this->getCard()->validate();
			$data['ccnumber'] = $this->getCard()->getNumber();
			$data['ccexp'] = $this->getCard()->getExpiryDate('my');
		}
        $data['payment'] = 'creditcard';

        if ('update_customer' === $this->customer_vault) {
            $data['customer_vault_id'] = $this->getCardReference();
        }

        return array_merge(
            $data,
            $this->getBillingData(),
            $this->getShippingData()
        );
    }
}
