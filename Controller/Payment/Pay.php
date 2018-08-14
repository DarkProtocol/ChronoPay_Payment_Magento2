<?php

namespace Chronopay\Payment\Controller\Payment;

/**
 * Class Pay init payment and redirect to payment url
 */
class Pay extends \Magento\Framework\App\Action\Action
{	

    /** @var \Magento\Sales\Model\OrderFactory */
    private $orderFactory;

    /** @var \Magento\Checkout\Model\Session */
    private $checkoutSession;


    /** @var \Chronopay\Payment\Helper\Data */
    private $dataHelper;


    /** @var \Chronopay\Payment\Model\ChronopayPayment */
    private $chronopayModel;

	
    /**
     * Construct
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $pageFactory
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Chronopay\Payment\Helper\Data $dataHelper
     * @param \Chronopay\Payment\Model\ChronopayPayment $chronopayModel
     * @return boolean
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Chronopay\Payment\Helper\Data $dataHelper,
        \Chronopay\Payment\Model\ChronopayPayment $chronopayModel
    ) {
        //$this->_pageFactory = $pageFactory;
        $this->orderFactory = $orderFactory;
        $this->checkoutSession = $checkoutSession;
        $this->dataHelper = $dataHelper;
        $this->chronopayModel = $chronopayModel;
        return parent::__construct($context);
    }


    /** 
     * Execute action
     */
    public function execute()
    {	

        // get last order id
        $orderId = $this->checkoutSession->getLastOrderId();

        // get order by last order id
        $order = $this->orderFactory->create()->load($orderId);

        // check order
        if (
            !$this->dataHelper->getIsActive() 
            || !$order->getId()
            || empty($this->dataHelper->getPaymentsUrl())
            || empty($this->dataHelper->getProductId())
            || empty($this->dataHelper->getSharedSec())
        ) {
            return $this->_redirect('/');
        }

        // check is new order 
        if (!$this->chronopayModel->isOrderNewForChronopay($order)) {
            return $this->_redirect('/');
        }

        
        // change status code
        $order->setStatus(\Chronopay\Payment\Model\ChronopayPayment::CHRONOPAY_PENDING_STATUS_CODE);

        if ($order->save()) {
            // if save status -> generate payment and redirect to url
            $orderPrice = (float)$order->getGrandTotal() - (float)$order->getShippingAmount();
            $successUrl = $this->_url->getUrl('checkout/onepage/success');
            $redirectUrl = $this->dataHelper->generatePaymentUrl($orderId, $orderPrice, $successUrl);
            return $this->_redirect($redirectUrl);
        }

        return $this->_redirect('/');
        
    }
}