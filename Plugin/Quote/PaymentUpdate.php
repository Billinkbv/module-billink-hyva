<?php

namespace Billink\BillinkHyva\Plugin\Quote;

use Billink\Billink\Gateway\Helper\Workflow;
use Billink\Billink\Model\Ui\ConfigProvider;
use Billink\Billink\Observer\DataAssignObserver;
use Magento\Quote\Api\Data\AddressInterface;
use Magento\Quote\Model\Quote\Payment;

class PaymentUpdate
{
    public function __construct(
        private readonly Workflow $workflowHelper
    ) {
    }

    public function processPayment(
        Payment $payment,
        AddressInterface $address,
        $method = null
    ) {
        if ($method === null) {
            $method = $payment->getMethod();
        }
        $oldValue = $payment->getAdditionalInformation(DataAssignObserver::CUSTOMER_TYPE);

        if ($method === ConfigProvider::CODE_MIDPAGE) {
            $company = trim((string)$address->getCompany());
            $customerType = $company ? 'B' : 'P';

            $payment->setAdditionalInformation(
                DataAssignObserver::CUSTOMER_TYPE,
                $customerType
            );

            $payment->setAdditionalInformation(
                DataAssignObserver::WORKFLOW_NUMBER,
                $this->workflowHelper->getNumber($customerType)
            );
        } else {
            // Reset stored information
            if ($oldValue) {
                $payment->setAdditionalInformation(DataAssignObserver::CUSTOMER_TYPE, null);
                $payment->setAdditionalInformation(DataAssignObserver::WORKFLOW_NUMBER, null);
            }
        }
    }
}
