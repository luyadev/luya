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
           'successLink' => Url::toRoute(['/mystore/store-checkout/success'], true), // user has paid successfull
           'errorLink' => Url::toRoute(['/mystore/store-checkout/error'], true), // user got a payment error
           'backLink' => Url::toRoute(['/mystore/store-checkout/back'], true), // user has pushed the back button
       ]);
        
       Yii::$app->session->set('storeTransactionId', $process->getId()); // you can store this information in your shop logic to know the transaction id later on!
        
       return $process->dispatch($this); // where $this is the current controller environment
    }
    
    public function actionSuccess()
    {
        $process = PaymentProcess::findById(Yii::$app->session->get('storeTransactionId', 0));
        
        // create order for customer ...
        // ...
        
        $process->close(PaymentProcess::STATE_SUCCESS);
    }
    
    public function actionError()
    {
        $process = PaymentProcess::findById(Yii::$app->session->get('storeTransactionId', 0));
        
        // display error for payment
        
        $process->close(PaymentProcess::STATE_ERROR);
    }
    
    public function actionBack()
    {
        $process = PaymentProcess::findById(Yii::$app->session->get('storeTransactionId', 0));
        
        // redirect the user back to where he can choose another payment.
        
        $process->close(PaymentProcess::STATE_BACK);
    }
}
```