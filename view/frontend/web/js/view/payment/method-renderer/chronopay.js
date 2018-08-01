define(
    [   
        'Magento_Checkout/js/view/payment/default',
        'mage/url'
    ],
    function (Component, mageUrl) {
        'use strict';
 
        return Component.extend({
            defaults: {
                redirectAfterPlaceOrder: false,
                template: 'Chronopay_Payment/payment/chronopay'
            },
            afterPlaceOrder: function () {
                window.location.replace(mageUrl.build('chronopay/payment/pay'));
                return false;
            }
        });
    }
);