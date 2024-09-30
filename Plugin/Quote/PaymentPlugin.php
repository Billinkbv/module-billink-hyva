<?php

namespace Billink\BillinkHyva\Plugin\Quote;

use Billink\Billink\Gateway\Helper\Workflow;
use Billink\Billink\Model\Ui\ConfigProvider;
use Billink\Billink\Observer\DataAssignObserver;
use Magento\Quote\Model\Quote\Payment as SubjectClass;

class PaymentPlugin
{
    public function __construct(
        private readonly Workflow $workflowHelper
    ) {
    }

    public function afterSetMethod(
        SubjectClass $subject,
        SubjectClass $result,
        $method
    ) {
        $quote = $subject->getQuote();
        $address = $quote->getBillingAddress();
        $oldValue = $subject->getAdditionalInformation(DataAssignObserver::CUSTOMER_TYPE);

        if ($method === ConfigProvider::CODE_MIDPAGE) {
            $company = trim((string)$address->getCompany());
            $customerType = $company ? 'B' : 'P';

            $subject->setAdditionalInformation(
                DataAssignObserver::CUSTOMER_TYPE,
                $customerType
            );

            $subject->setAdditionalInformation(
                DataAssignObserver::WORKFLOW_NUMBER,
                $this->workflowHelper->getNumber($customerType)
            );
        } else {
            // Reset stored information
            if ($oldValue) {
                $subject->setAdditionalInformation(DataAssignObserver::CUSTOMER_TYPE, null);
                $subject->setAdditionalInformation(DataAssignObserver::WORKFLOW_NUMBER, null);
            }
        }
        return $result;
    }
}
