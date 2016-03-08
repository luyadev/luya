<?php

use yii\db\Schema;
use yii\db\Migration;

class m141104_114809_admin_user extends Migration
{
    public function up()
    {
        $this->createTable('admin_user', [
            'id' => 'pk',
            'firstname' => Schema::TYPE_STRING,
            'lastname' => Schema::TYPE_STRING,
            'title' => Schema::TYPE_SMALLINT,
            'email' => 'VARCHAR(120) NOT NULL UNIQUE',
            'password' => Schema::TYPE_STRING,
            'password_salt' => Schema::TYPE_STRING,
            'auth_token' => Schema::TYPE_STRING,
            'is_deleted' => Schema::TYPE_SMALLINT,
        ]);
    }

    public function down()
    {
        echo "m141104_114809_admin_user cannot be reverted.\n";

        return false;
    }
}
