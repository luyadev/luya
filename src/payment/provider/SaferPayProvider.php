<?php

namespace luya\payment\provider;

use Curl\Curl;
use luya\payment\base\Provider;
use luya\payment\PaymentException;
use luya\payment\base\ProviderInterface;

class SaferPayProvider extends Provider implements ProviderInterface
{  
    public function getId()
    {
        return 'saferpay';
    }
    
    public function callCreate($accountId, $amount, $currency, $description, $orderId, $successLink, $failLink, $backLink, $notifyUrl)
    {
        $curl = new Curl();
        $curl->post('https://www.saferpay.com/hosting/CreatePayInit.asp', [
            'ACCOUNTID' => $accountId,
            'AMOUNT' => $amount,
            'CURRENCY' => $currency,
            'DESCRIPTION' => $description,
            'ORDERID' => $orderId,
            'SUCCESSLINK' => $successLink,
            'FAILLINK' => $failLink,
            'BACKLINK' => $backLink,
            'NOTIFYURL' => $notifyUrl,
        ]);
        
        if (!$curl->error) {
            return $curl->response;
        }
        
        throw new PaymentException($curl->error_message);
    }
}