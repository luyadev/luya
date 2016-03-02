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
        'accountId' => '123123123',
    ]
    // ...
],
```

add your transaction where ever you are:


```php

$transaction = new \luya\payment\transaction\SaferPayTransaction();

$process = new payment\PaymentProcess($transaction, [
    'amount' => 123123, // in cent
    'orderId' => 'uniqueOrderIdNumber',
    'currency' => 'USD',
    'successLink' => 'example.com/onlinestore/success.php', // user has paid successfull
    'errorLink' => 'example.com/onlinestore/error.php', // user got a payment error
    'backLink' => 'example.com/onlinestore/back.php', // used has pushed the back button
]); 

$uniqueProcessId = $process->getId();

$response = $process->dispatch(); // will create a yii\web\Response
Yii::$app->end($response); // or return $process->dispatch(); as controllers can handle response objects

```

lets assume the user successfull entered the url so he will land back in `successLink` in our case `success.php`:

```php
// success.php


$process = payment\PaymentProcess::findActive(); // will find the above payment process based on session data (or others?)

// save the informations related to your estore, mark the order as paid

$proccess->close();

```