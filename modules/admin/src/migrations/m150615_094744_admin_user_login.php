<?php

use yii\db\Migration;

class m150615_094744_admin_user_login extends Migration
{
    public function up()
    {
        $this->createTable('admin_user_login', [
            'id' => 'pk',
            'user_id' => 'int(11) NOT NULL',
            'timestamp_create' => 'int(11) NOT NULL',
            'auth_token' => 'varchar(120) NOT NULL',
            'ip' => 'varchar(15) NOT NULL',
        ]);
    }

    public function down()
    {
        echo "m150615_094744_admin_user_login cannot be reverted.\n";

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
