<?php

namespace Billink\BillinkHyva\Plugin\Quote;

use Magento\Quote\Model\Quote\Payment as SubjectClass;

class PaymentPlugin extends PaymentUpdate
{
    public function afterSetMethod(
        SubjectClass $subject,
        SubjectClass $result,
        $method
    ) {
        $quote = $subject->getQuote();
        $address = $quote->getBillingAddress();
        $this->processPayment($subject, $address, $method);
        return $result;
    }
}
