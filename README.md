# ChronoPay_Payment_Magento2

Chronopay Payment Magento 2 modile.

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
Далее зайдите в Stores -> Configuration -> Sales -> Payment Methods -> Chronopay Payment и заполните поля.
SharedSec, Product ID Вам должны выдать. Payments Url (по умолчанию https://payments.chronopay.com) это url, где будет генерироваться оплата (если вы понятия не имеете, что это, то оставьте без изменений). Title - название платежной системы на странице оформления
