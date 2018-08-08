<?php 

namespace Chronopay\Payment\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Store\Model\ScopeInterface;

class Data extends AbstractHelper 
{

	/** 
     * XML path to module config in system.xml
	 */
	const XML_CONFIG_PATH = 'payment/chronopay/';


	/** @var null|bool $isActive */
	private $isActive = null;

	/** @var null|string $sharedSec */
	private $paymentsUrl = null;

	/** @var null|string $productId */
	private $productId = null;

	/** @var null|string $sharedSec */
	private $sharedSec = null;
	

	/**
     * Get config value
     *
     * @param string $field
     * @param mixed $storeId
     * @return mixed
	 */
	private function getConfigValue($field, $storeId = null)
	{
		return $this->scopeConfig->getValue(
			self::XML_CONFIG_PATH  . $field, ScopeInterface::SCOPE_STORE, $storeId
		);
	}


	/** 
	 * Get paymentsUrl
	 *
	 * @return bool
	 */
	public function getPaymentsUrl()
	{	
		if ($this->paymentsUrl === null) {
			$this->paymentsUrl = (string) $this->getConfigValue('payments_url');
		}

		return $this->paymentsUrl;
	}


	/** 
	 * Get product id from config
	 *
	 * @return string
	 */
	public function getProductId()
	{	
		if ($this->productId === null) {
			$this->productId = (string) $this->getConfigValue('product_id');
		}

		return $this->productId;
	}


	/** 
	 * Get SharedSec
	 *
	 * @return string
	 */
	public function getSharedSec()
	{	
		if ($this->sharedSec === null) {
			$this->sharedSec = (string) $this->getConfigValue('sharedsec');
		}

		return $this->sharedSec;
	}


	/** 
	 * Get isActive
	 *
	 * @return bool
	 */
	public function getIsActive()
	{	
		if ($this->isActive === null) {
			$this->isActive = (bool) $this->getConfigValue('active');
		}

		return $this->isActive;
	}


	/**
	 * Generate payment url
	 *
	 * @param string $orderId
	 * @param float $orderPrice
	 * @param string $successUrl
	 *
	 * @return string
	 */
	public function generatePaymentUrl($orderId, $orderPrice, $successUrl)
	{
		$url = $this->getPaymentsUrl();
		$url .= '?product_id=' . urlencode($this->getProductId());
		$url .= '&sign=' . urlencode($this->generatePaymentSign($orderPrice, $orderId));
		$url .= '&order_id=' . urlencode($orderId);
		$url .= '&product_price=' . urlencode($orderPrice);
		$url .= '&success_url=' . urlencode($successUrl);

		return $url;
	}


	/**
	 * Generate payment sign
	 *
	 * @param string $orderId
	 * @param float $orderPrice
	 *
	 * @return string
	 */
	private function generatePaymentSign($orderPrice, $orderId)
	{	
		return md5(
			$this->getProductId() . '-' . 
			$orderPrice . '-' . 
			$orderId . '-' . $this->getSharedSec()
		);
	}


	/**
	 * Check callback sign
	 *
	 * @param string $sign
	 * @param string $customerId
	 * @param string $transactionId
	 * @param string $transactionType
	 * @param string $total
	 *
	 * @return bool
	 */
	public function checkCallbackSign($sign, $customerId, $transactionId, $transactionType, $total)
	{
		$generatedSign = md5($this->getSharedSec() . $customerId . $transactionId . $transactionType . $total);
		return $sign === $generatedSign;
	} 

}