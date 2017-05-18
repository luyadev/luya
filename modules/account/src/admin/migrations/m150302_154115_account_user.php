<?php


use yii\db\Migration;

class m150302_154115_account_user extends Migration
{
    public function safeUp()
    {
        $this->createTable('account_user', [
            'id' => $this->primaryKey(),
            'firstname' => $this->string(255),
            'lastname' => $this->string(255),
            'email' => $this->string(255),
            'password' => $this->string(255),
            'password_salt' => $this->string(255),
            'auth_token' => $this->string(255),
            'is_deleted' => $this->integer(11)->defaultValue(0),
            'gender' => $this->smallInteger(1)->defaultValue(0),
            'street' => $this->string(120),
            'zip' => $this->string(20),
            'city' => $this->string(80),
            'country' => $this->string(80),
            'company' => $this->string(80),
            'subscription_newsletter' => $this->boolean()->defaultValue(false),
            'subscription_medianews' => $this->boolean()->defaultValue(false),
            'verification_hash' => $this->string(80),
            'is_mail_verified' => $this->boolean()->defaultValue(false),
            'is_active' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('account_user');
    }
}
