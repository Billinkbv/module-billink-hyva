<?php
namespace Billink\BillinkHyva\Model\Payment\PlaceOrderService;

use Billink\Billink\Gateway\Helper\SessionReader;
use Hyva\Checkout\Model\Magewire\Payment\AbstractOrderData;
use Hyva\Checkout\Model\Magewire\Payment\AbstractPlaceOrderService;
use Magento\Framework\Exception\LocalizedException;
use Magento\Quote\Api\CartManagementInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Api\OrderRepositoryInterface;
use Psr\Log\LoggerInterface;

class MidpageOrderService extends AbstractPlaceOrderService
{
    protected OrderRepositoryInterface $orderRepository;
    protected LoggerInterface $logger;

    public function __construct(
        CartManagementInterface $cartManagement,
        OrderRepositoryInterface $orderRepository,
        LoggerInterface $logger,
        AbstractOrderData $orderData = null
    ) {
        $this->orderRepository = $orderRepository;
        $this->logger = $logger;

        parent::__construct(
            $cartManagement,
            $orderData
        );
    }

    /**
     * Redirect to the Billink page
     *
     * @throws \Exception
     */
    public function getRedirectUrl(Quote $quote, ?int $orderId = null): string
    {
        try {
            $order = $this->orderRepository->get($orderId);
            return $order->getPayment()?->getAdditionalInformation()[SessionReader::REDIRECT_URL];
        } catch (\Exception $e) {
            $this->logger->critical("Couldn't redirect user to Billink page ".$e->getMessage());
            throw new LocalizedException(__('Unable to retrieve payment api information, please try again or concat support.'));
        }
    }
}
