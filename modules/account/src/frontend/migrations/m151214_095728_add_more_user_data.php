<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_095728_add_more_user_data extends Migration
{
    public function up()
    {
        $this->addColumn('account_user', 'gender', 'tinyint(1) default 0'); // 0 = Frau; 1 = Herr
        $this->addColumn('account_user', 'street', 'varchar(120)');
        $this->addColumn('account_user', 'zip', 'varchar(20)');
        $this->addColumn('account_user', 'city', 'varchar(80)');
        $this->addColumn('account_user', 'country', 'varchar(80)');
        $this->addColumn('account_user', 'company', 'varchar(80)');
        $this->addColumn('account_user', 'subscription_newsletter', 'tinyint(1) default 0');
        $this->addColumn('account_user', 'subscription_medianews', 'tinyint(1) default 0');
        $this->addColumn('account_user', 'verification_hash', 'varchar(80)');
        $this->addColumn('account_user', 'is_mail_verified', 'tinyint(1) default 0');
        $this->addColumn('account_user', 'is_active', 'tinyint(1) default 0');
    }

    public function down()
    {
        echo "m151214_095728_add_more_user_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
