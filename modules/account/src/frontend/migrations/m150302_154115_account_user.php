<?php

use yii\db\Schema;
use yii\db\Migration;

class m150302_154115_account_user extends Migration
{
    public function up()
    {
        $this->createTable('account_user', [
            'id' => 'pk',
            'firstname' => Schema::TYPE_TEXT,
            'lastname' => Schema::TYPE_TEXT,
            'email' => Schema::TYPE_TEXT,
            'password' => Schema::TYPE_STRING,
            'password_salt' => Schema::TYPE_STRING,
            'auth_token' => Schema::TYPE_STRING,
            'is_deleted' => 'tinyint(11) default 0',
        ]);
    }

    public function down()
    {
        echo "m150302_154115_account_user cannot be reverted.\n";

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
