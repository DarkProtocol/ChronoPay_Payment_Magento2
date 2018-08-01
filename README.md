# ChronoPay_Payment_Magento2

Chronopay Payment Magento 2 module.

# Установка
1. сначала зайдите в директорию Magento 2
2. Выполните команды:

```cmd
composer config repositories.chronopay_payment git https://github.com/DarkProtocol/ChronoPay_Payment_Magento2.git
composer require chronopay/payment:dev-master
```

Когда все зависиммости подхватятся, выполните следующие комнады:

```cmd
php bin/magento module:enable Chronopay_Payment --clear-static-content
php bin/magento setup:upgrade
```

После этого шага, модуль должен быть установлен. 

В системе должны появится 2 новых статуса заказа: `chronopay_payment_pending`
и `chronopay_payment_success`.

`chronopay_payment_pending` означает, что пользователь посетил страницу оплаты ChronoPay, но подтверждение о его транзакции еще не пришло.

`chronopay_payment_success` означает, что пользователь успешно оплатил заказ (без учета стоимости доставки).

Модуль не будет работать, если эти статусы будут отсутствовать.


# Настройка
Далее зайдите в Stores -> Configuration -> Sales -> Payment Methods -> Chronopay Payment и заполните поля.
SharedSec, Product ID Вам должны выдать. Payments Url (по умолчанию https://payments.chronopay.com) это url, где будет генерироваться оплата (если вы понятия не имеете, что это, то оставьте без изменений). Title - название платежной системы на странице оформления. Все поля обязательны для заполнения, иначе модуль не будет работать.
Callback url или cbUrl (на этот url приходят подтверждения оплаты) для Вашего магазина будет http://yourdomain.com/chronopay/payment/callback


