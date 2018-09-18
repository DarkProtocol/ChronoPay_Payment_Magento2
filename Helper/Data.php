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

    /** @var null|string $cbUrl */
    private $cbUrl = null;

    /** @var null|string $cbType */
    private $cbType = null;

    /** @var null|string $successUrl */
    private $successUrl = null;

    /** @var null|string $declineUrl */
    private $declineUrl = null;

    /** @var null|string $paymentTypeGroupId */
    private $paymentTypeGroupId = null;

    /** @var null|string $language */
    private $language = null;

    /** @var null|int $orderTimelimit */
    private $orderTimelimit = null;

    /** @var null|int $orderExpiretime */
    private $orderExpiretime = null;
    

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
     * Get param cbUrl
     *
     * @return string | null 
     */
    public function getCbUrl()
    {   
        if ($this->cbUrl === null) {
            $this->cbUrl = $this->getConfigValue('cbUrl');
        }

        return $this->cbUrl;
    }


    /**
     * Get param cbType
     *
     * @return string | null 
     */
    public function getCbType()
    {   
        if ($this->cbType === null) {
            $this->cbType = $this->getConfigValue('cbType');
        }

        return $this->cbType;
    }


    /**
     * Get param successUrl
     *
     * @return string | null 
     */
    public function getSuccessUrl()
    {   
        if ($this->successUrl === null) {
            $this->successUrl = $this->getConfigValue('successUrl');
        }

        return $this->successUrl;
    }


    /**
     * Get param declineUrl
     *
     * @return string | null 
     */
    public function getDeclineUrl()
    {   
        if ($this->declineUrl === null) {
            $this->declineUrl = $this->getConfigValue('declineUrl');
        }

        return $this->declineUrl;
    }


    /**
     * Get param paymentTypeGroupId
     *
     * @return string | null 
     */
    public function getPaymentTypeGroupId()
    {   
        if ($this->paymentTypeGroupId === null) {
            $this->paymentTypeGroupId = $this->getConfigValue('paymentTypeGroupId');
        }

        return $this->paymentTypeGroupId;
    }


    /**
     * Get param language
     *
     * @return string | null 
     */
    public function getLanguage()
    {   
        if ($this->language === null) {
            $this->language = $this->getConfigValue('language');
        }

        return $this->language;
    }


    /**
     * Get param orderTimelimit
     *
     * @return int | null 
     */
    public function getOrderTimelimit()
    {   

        if ($this->orderTimelimit === null && $this->getConfigValue('orderTimelimit') != null) {
            $this->orderTimelimit = (int)$this->getConfigValue('orderTimelimit');
        }

        return $this->orderTimelimit;
    }


    /**
     * Get param orderExpiretime
     *
     * @return int | null 
     */
    public function getOrderExpiretime()
    {
        if ($this->orderExpiretime === null && $this->getConfigValue('orderExpiretime') != null) {
            $this->orderExpiretime = (int)$this->getConfigValue('orderExpiretime');
        }

        return $this->orderExpiretime;
    }


    /**
     * Generate payment url
     *
     * @param CustomerData $customerData
     * @param string $orderId
     * @param float $orderPrice
     * @param string $successUrl
     *
     * @return string
     */
    public function generatePaymentUrl(CustomerData $customerData, $orderId, $orderPrice, $successUrl)
    {

        // get success url
        if ($this->getSuccessUrl()) {
            $successUrl = $this->getSuccessUrl();
        } 

        $url = $this->getPaymentsUrl();
        $url .= '?product_id=' . urlencode($this->getProductId());
        $url .= '&order_id=' . urlencode($orderId);
        $url .= '&product_price=' . urlencode($orderPrice);
        $url .= '&success_url=' . urlencode($successUrl);

        // add decline url
        if (strlen($this->getDeclineUrl()) > 0) {
            $url .= '&decline_url=' . urlencode($this->getDeclineUrl());
        }

        // add cb_url
        if (strlen($this->getCbUrl()) > 0) {
            $url .= '&cb_url=' . $this->getCbUrl();
        } 

        // add cb_type
        if (strlen($this->getCbType()) > 0) {
            $url .= '&cb_type=' . $this->getCbType();
        } 

        // add payment_type_group_id
        if (strlen($this->getPaymentTypeGroupId()) > 0) {
            $url .= '&payment_type_group_id=' . $this->getPaymentTypeGroupId();
        } 

        // add language
        if (strlen($this->getLanguage()) > 0) {
            $url .= '&language=' . $this->getLanguage();
        } 

        // add orderTimelimit
        if ($this->getOrderTimelimit() != null) {

            $url .= '&orderTimelimit=' . $this->getOrderTimelimit();
            $url .= '&sign=' . $this->generatePaymentSign($orderPrice, $orderId, $this->getOrderTimelimit());

        } elseif ($this->getOrderExpiretime() != null) {

            $orderExpiretime = date('Y-m-d\TH:i:sO', time() + $this->getOrderExpiretime() * 60);
            $url .= '&orderExpiretime=' . urlencode($orderExpiretime);
            $url .= '&sign=' . $this->generatePaymentSign($orderPrice, $orderId, $orderExpiretime);

        } else {
            $url .= '&sign=' . $this->generatePaymentSign($orderPrice, $orderId);
        }

        /* CLIENT ADRESS DATA */
        // add country
        
        if ($customerData->getCountry() != null) {
            $url .= '&country=' . $customerData->getCountry();
        } 


        // add city
        if ($customerData->getCity() != null) {
            $url .= '&city=' . urlencode($customerData->getCity());
        } 

        // add street
        if ($customerData->getStreet() != null) {
            $url .= '&street=' . urlencode($customerData->getStreet());
        } 

        // add zip
        if ($customerData->getZip() != null) {
            $url .= '&zip=' . urlencode($customerData->getZip());
        } 
        


        /* CLIENT NAME DATA */

        // add f_name
        if ($customerData->getFirstName() != null) {
            $url .= '&f_name=' . urlencode($customerData->getFirstName());
        } 

        // add s_name
        if ($customerData->getLastName() != null) {
            $url .= '&s_name=' . urlencode($customerData->getLastName());
        } 

        // add phone
        if ($customerData->getPhone() != null) {
            $url .= '&phone=' . urlencode($customerData->getPhone());
        } 

        // add email
        if ($customerData->getEmail() != null) {
            $url .= '&email=' . urlencode($customerData->getEmail());
        }


        return $url;

    }


    /**
     * Generate payment sign
     *
     * @param string $orderId
     * @param float $orderPrice
     * @param int | null $additionalParam
     *
     * @return string
     */
    private function generatePaymentSign($orderPrice, $orderId, $additionalParam = null)
    {   
        $additionalParamString = '';

        if ($additionalParam != null) {
            $additionalParamString = $additionalParam . '-' ;
        }

        return md5(
            $this->getProductId() . '-' . $orderPrice . '-' . 
            $orderId . '-' . $additionalParamString . $this->getSharedSec()
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
