<?php

namespace Chronopay\Payment\Controller\Payment;

/**
 * Class Callback handle callback request 
 */
class Callback extends \Magento\Framework\App\Action\Action
{	


	/** @var \Magento\Sales\Model\OrderFactory */
	private $orderFactory;


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
	 * @param \Chronopay\Payment\Helper\Data $dataHelper
	 * @param \Chronopay\Payment\Model\ChronopayPayment $chronopayModel
	 * @return boolean
	 */
	public function __construct(
		\Magento\Framework\App\Action\Context $context,
		\Magento\Framework\View\Result\PageFactory $pageFactory,
		\Magento\Sales\Model\OrderFactory $orderFactory,
		\Chronopay\Payment\Helper\Data $dataHelper,
		\Chronopay\Payment\Model\ChronopayPayment $chronopayModel
	) {
		//$this->_pageFactory = $pageFactory;
		$this->orderFactory = $orderFactory;
		$this->dataHelper = $dataHelper;
		$this->chronopayModel = $chronopayModel;
		return parent::__construct($context);
	}


	/** 
	 * Execute action
	 */
	public function execute()
	{	

		// check all params
		$customerId = $this->getRequest()->getParam('customer_id'); 
		$transactionId = $this->getRequest()->getParam('transaction_id');
		$transactionType = $this->getRequest()->getParam('transaction_type');
		$total = $this->getRequest()->getParam('total'); 
		$sign = $this->getRequest()->getParam('sign'); 
		$orderId = $this->getRequest()->getParam('order_id'); 

		if (!$customerId || !$transactionId || !$transactionType || !$total || !$sign || !$orderId) {
			return $this->_redirect('/');
		}

		// сheck module 
		if (!$this->dataHelper->getIsActive() || empty($this->dataHelper->getSharedSec())) {
			return $this->_redirect('/');
		}

		// check sign
		if (!$this->dataHelper->checkCallbackSign($sign, $customerId, $transactionId, $transactionType, $total)) {
			return $this->_redirect('/');
		}

		// get order 
		$order = $this->orderFactory->create()->load($orderId);

		// check order
		if (!$order->getId()) {
			return $this->_redirect('/');
		}

		// check order id pending payment
		if (!$this->chronopayModel->isOrderPendingForChronopay($order)) {
			return $this->_redirect('/');
		}

		// change status code
		$order->setStatus(\Chronopay\Payment\Model\ChronopayPayment::CHRONOPAY_SUCCESS_STATUS_CODE);
		$order->save();

	    return $this->_redirect('/');
	}

}