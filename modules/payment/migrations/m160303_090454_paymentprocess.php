<?php

use yii\db\Schema;
use yii\db\Migration;

class m160303_090454_paymentprocess extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('payment_process', [
            'id' => 'pk',
            'salt' => 'varchar(120) NOT NULL',
            'hash' => 'varchar(120) UNIQUE NOT NULL',
            'random_key' => 'varchar(32) UNIQUE NOT NULL',
            'amount' => 'int(11) NOT NULL', // int value in cents
            'currency' => 'varchar(10) NOT NULL',
            'order_id' => 'varchar(50) NOT NULL',
            'provider_name' => 'varchar(50) NOT NULL',
            'success_link' => 'varchar(255) NOT NULL',
            'error_link' => 'varchar(255) NOT NULL',
            'back_link' => 'varchar(255) NOT NULL',
            'transaction_config' => 'text NOT NULL',
            'close_state' => 'int(11) DEFAULT 0',
            'is_closed' => 'tinyint(1) DEFAULT 0',
        ]);
        
        $this->createTable('payment_process_trace', [
            'process_id' => 'int(11) NOT NULL',
            'event' => 'varchar(250)',
            'message' => 'varchar(255)',
            'timestamp' => 'int(11) NOT NULL',
            'get' => 'text',
            'post' => 'text',
            'server' => 'text',
        ]);
    }

    public function safeDown()
    {
        return $this->dropTable('payment_process');
    }
}
