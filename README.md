# Billink for Magento 2 - Hyva Checkout compatibility

This is the official composer package of the Billink payment module for Magento 2 and Hyva Checkout.

Please visit billink.nl to set up an account.

---

Require Magento 2.4+ and PHP 8.1+.

---

### Quick installation instructions:

1. Go to your Magento 2 installation directory.
2. Execute `bin/magento maintenance:enable`
3. Execute `composer require billinkbv/module-billink:^2.1 billinkbv/module-billink-hyva`
4. Execute `bin/magento module:enable Billink_Billink Billink_BillinkHyva`
5. Execute `bin/magento setup:upgrade`
6. Execute `bin/magento setup:di:compile`
7. Execute `bin/magento setup:static-content:deploy`
8. Execute `bin/magento cache:flush`
9. Execute `bin/magento maintenance:disable`

For detailed information, see our [Integrations page](https://www.billink.nl/zakelijk/integraties/magento).
