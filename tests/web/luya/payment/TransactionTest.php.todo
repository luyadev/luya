<?php

namespace tests\web\luya\payment;


use luya\payment\transaction\SaferPayTransaction;
/**
 * @author nadar
 */
class TransactionTest extends \tests\web\Base
{
    public function testSaferPayAction()
    {
        $transaction = new SaferPayTransaction(new \luya\payment\provider\SaferPayProvider(), ['accountId' => 123123]);
        
        $this->assertEquals(true, is_object($transaction));
    }
}
