<?php

use yii\db\Migration;

class m150615_094744_admin_user_login extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_user_login', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'timestamp_create' => $this->integer(11)->notNull(),
            'auth_token' => $this->string(120)->notNull(),
            'ip' => $this->string(15)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_user_login');
    }
}
