<?php

use yii\db\Migration;

class m150722_125833_remote_site extends Migration
{
    public function safeUp()
    {
        $this->createTable('remote_site', [
            'id' => $this->primaryKey(),
            'token' => $this->string(120)->notNull(),
            'url' => $this->string(120)->notNull(),
            'auth_is_enabled' => $this->boolean()->defaultValue(false),
            'auth_user' => $this->string(120),
            'auth_pass' => $this->string(120),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('remote_site');
    }
}
