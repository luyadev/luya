<?php

use yii\db\Schema;
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
        ]);
    }

    public function safeDown()
    {
    	$this->dropTable('account_user');
    }
}
