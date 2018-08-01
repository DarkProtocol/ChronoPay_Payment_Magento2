<?php

namespace Chronopay\Payment\Setup;


use \Chronopay\Payment\Model\ChronopayPayment;

/**
 * Class InstallData
 */
class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{

    /** @var \Magento\Sales\Model\Order\StatusFactory */
    protected $statusFactory;

    /** @var \Magento\Sales\Model\ResourceModel\Order\StatusFactory */
    protected $statusResourceFactory;

    /**
     * Сonstructor
     *
     * @param \Magento\Sales\Model\Order\StatusFactory $statusFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\StatusFactory $statusResourceFactory
     */
    public function __construct(
        \Magento\Sales\Model\Order\StatusFactory $statusFactory,
        \Magento\Sales\Model\ResourceModel\Order\StatusFactory $statusResourceFactory
    ) {
        $this->statusFactory = $statusFactory;
        $this->statusResourceFactory = $statusResourceFactory;
    }

    /**
     * Installs data for a module
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface $context
     */
    public function install (
        \Magento\Framework\Setup\ModuleDataSetupInterface $setup, 
        \Magento\Framework\Setup\ModuleContextInterface $context
    ) {

        // add pending status
        $this->addStatus(
            ChronopayPayment::CHRONOPAY_PENDING_STATUS_CODE,
            ChronopayPayment::CHRONOPAY_PENDING_STATUS_LABEL
        );

        // add success status
        $this->addStatus(
            ChronopayPayment::CHRONOPAY_SUCCESS_STATUS_CODE,
            ChronopayPayment::CHRONOPAY_SUCCESS_STATUS_LABEL
        );
    }


    /**
     * Add and save order status to db
     *
     * @param string $statusCode 
     * @param string $statusLabel 
     */
    private function addStatus($statusCode, $statusLabel)
    {
        $statusResource = $this->statusResourceFactory->create();
        $status = $this->statusFactory->create();

        $status->setData([
            'status' => $statusCode,
            'label' => $statusLabel,
        ]);

        $statusResource->save($status);
    }

}