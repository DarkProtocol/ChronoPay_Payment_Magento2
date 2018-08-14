<?php
 
namespace Chronopay\Payment\Model;
 
/**
 * Pay In Store payment method model
 */
class ChronopayPayment extends \Magento\Payment\Model\Method\AbstractMethod
{
    
    /**
     * Payment pending order status code and label 
     */
    const CHRONOPAY_PENDING_STATUS_CODE = 'chronopay_payment_pending';
    const CHRONOPAY_PENDING_STATUS_LABEL = 'ChronoPay Payment pending';


    /**
     * Success payment order status code and label 
     */
    const CHRONOPAY_SUCCESS_STATUS_CODE = 'chronopay_payment_success';
    const CHRONOPAY_SUCCESS_STATUS_LABEL = 'ChronoPay Payment successful';


    /**
     * Refund payment order status code and label 
     */
    const CHRONOPAY_REFUND_STATUS_CODE = 'chronopay_payment_refund';
    const CHRONOPAY_REFUND_STATUS_LABEL = 'ChronoPay Payment refund';


    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'chronopay';


    /**
     * Check is order new and is chronopay payment
     *
     * @return bool
     */
    public function isOrderNewForChronopay(\Magento\Sales\Model\Order $order)
    {   

        $paymentCode = $order->getPayment()->getMethodInstance()->getCode();
        $orderStatus = $order->getStatus();

        return $paymentCode == $this->_code 
                && $orderStatus != self::CHRONOPAY_PENDING_STATUS_CODE
                && $orderStatus != self::CHRONOPAY_SUCCESS_STATUS_CODE;
    }


    /**
     * Check is order chronopay_pending and is chronopay payment
     *
     * @return bool
     */
    public function isOrderPendingForChronopay(\Magento\Sales\Model\Order $order)
    {
        $paymentCode = $order->getPayment()->getMethodInstance()->getCode();
        $orderStatus = $order->getStatus();

        return $paymentCode == $this->_code && $orderStatus == self::CHRONOPAY_PENDING_STATUS_CODE;
    }


    /**
     * Check is order chronopay_success and is chronopay payment
     *
     * @return bool
     */
    public function isOrderSuccessForChronopay(\Magento\Sales\Model\Order $order)
    {
        $paymentCode = $order->getPayment()->getMethodInstance()->getCode();
        $orderStatus = $order->getStatus();

        return $paymentCode == $this->_code && $orderStatus == self::CHRONOPAY_SUCCESS_STATUS_CODE;
    }
}
