<?php

use yii\db\Schema;
use yii\db\Migration;

class m151214_095728_add_more_user_data extends Migration
{
    public function safeUp()
    {
        $this->addColumn('account_user', 'gender', $this->smallInteger(1)->defaultValue(0)); // 0 = Mrs; 1 = Mr
        $this->addColumn('account_user', 'street', $this->string(120));
        $this->addColumn('account_user', 'zip', $this->string(20));
        $this->addColumn('account_user', 'city', $thi->string(80));
        $this->addColumn('account_user', 'country',$this->string(80));
        $this->addColumn('account_user', 'company', $this->string(80));
        $this->addColumn('account_user', 'subscription_newsletter', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('account_user', 'subscription_medianews', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('account_user', 'verification_hash', $this->string(80));
        $this->addColumn('account_user', 'is_mail_verified', $this->smallInteger(1)->defaultValue(0));
        $this->addColumn('account_user', 'is_active', $this->smallInteger(1)->defaultValue(0));
    }

    public function safeDown()
    {
    	$this->dropColumn('account_user', 'gender');
    	$this->dropColumn('account_user', 'street');
    	$this->dropColumn('account_user', 'zip');
    	$this->dropColumn('account_user', 'city');
    	$this->dropColumn('account_user', 'country');
    	$this->dropColumn('account_user', 'company');
    	$this->dropColumn('account_user', 'subscription_newsletter');
    	$this->dropColumn('account_user', 'subscription_medianews');
    	$this->dropColumn('account_user', 'verification_hash');
    	$this->dropColumn('account_user', 'is_mail_verified');
    	$this->dropColumn('account_user', 'is_active');
    }
}
