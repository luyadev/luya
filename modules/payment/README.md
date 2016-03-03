LUYA PAYMENT IMPLEMENTATION
===========================

**under development**

require the payment module

```
composer require zephir/luya-payment-module
```

configure the payment module in your config

```
'modules' => [
    // ...
    'payment' => [
        'class' => 'payment\Module',
    ]
    // ...
],
```

add your transaction where ever you are:


```php

class StoreCheckoutController extends \luya\web\Controller
{
    public function actionIndex()
    {
         // The orderId/basketId should be an unique key for each transaction. based on this key the transacton
         // hash and auth token will be created.
        $orderId = 123456789;
        
       $process = new payment\PaymentProcess([
           'transactionConfig' => [
               'class' => SaferPayTransaction::className(),
               'accountId' => 'SAFERPAYACCOUNTID', // each transaction can have specific attributes, saferpay requires an accountId',
           ],
           'orderId' => $orderId,
           'amount' => 123123, // in cents
           'currency' => 'USD',
           'successLink' => 'example.com/onlinestore/success.php', // user has paid successfull
           'errorLink' => 'example.com/onlinestore/error.php', // user got a payment error
           'backLink' => 'example.com/onlinestore/back.php', // user has pushed the back button
       ]);
        
       $processId = $proccess->getId(); // you can store this information in your shop logic to know the transaction id later on!
        
       return $process->dispatch($this); // where $this is the current controller environment
    }
}
```

lets assume the user successfull entered the url so he will land back in `successLink` in our case `success.php`:

```php
// success.php


$process = payment\PaymentProcess::findBySession(); // will find the above payment process based on session data (or others?)

// save the informations related to your estore, mark the order as paid

$proccess->close();

```