<?php
namespace Billink\BillinkHyva\Block;

use Hyva\Checkout\Model\ConfigData\HyvaThemes\SystemConfigDesign;
use Magento\Framework\View\Element\Template;

class CheckoutTemplate extends Template
{
    public function __construct(
        Template\Context $context,
        protected readonly SystemConfigDesign $hyvaConfig,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    public function getData($key = '', $index = null)
    {
        $result = parent::getData($key, $index);
        if ($key === 'metadata') {
            // Add icon in case it will start working with Hyva.
            if (!is_array($result)) {
                $result = [];
            }
            $result['icon'] = [
                'src' => 'Billink_Billink::images/billink-logo-default.svg',
                'attributes' => [
                    'width' => $this->hyvaConfig->getUniversalIconWidth()
                ]
            ];
        }
        return $result;
    }
}
