<?php
namespace Chronopay\Payment\Block\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class FrontendModel
 */
class FrontendModel extends \Magento\Config\Block\System\Config\Form\Fieldset
{   

    /**
     * Generate url with site url
     *
     * @param $path
     * @return string
     */
    public function generateUrl($path)
    {
        return $this->_urlBuilder->getBaseUrl(['_secure' => 1]).$path;
    }

    /**
     * Return header comment part of html for fieldset
     *
     * @param AbstractElement $element
     * @return string
     */
    protected function _getHeaderCommentHtml($element)
    {
        return '<table class="comment">'.
        '<tr>'.
        '<td colspan="2" style="text-align: center; font-size: 18px;">'.
        __('Settings for ChronoPay Payments').
        '</td>'.
        '</tr>'.
        '<tr>'.
        '<td>'.__('Callback Url - url for ChronoPay transaction callback (cbUrl)').'</td>'.
        '<td>'.$this->generateUrl('chronopay/payment/callback').'</td>'.
        '</tr>'.
        '</table>';
    }
}