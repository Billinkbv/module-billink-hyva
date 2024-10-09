<?php

namespace Billink\BillinkHyva\Plugin\Quote;

use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Api\Data\CartInterface;
use Magento\Quote\Model\Quote\Address\BillingAddressPersister as SubjectClass;

class BillingAddressPersisterPlugin extends PaymentUpdate
{
    public function afterSave(
        SubjectClass $subject,
        $result,
        CartInterface $quote,
        AddressInterface $address
    ) {
        $payment = $quote->getPayment();
        $this->processPayment($payment, $address);
        return $result;
    }
}
