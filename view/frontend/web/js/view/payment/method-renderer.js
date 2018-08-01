define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'chronopay',
                component: 'Chronopay_Payment/js/view/payment/method-renderer/chronopay'
            }
        );
        return Component.extend({});
    }
);