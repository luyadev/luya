<?php

use yii\db\Migration;

class m150617_200836_admin_user_online extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_user_online', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11)->notNull(),
            'last_timestamp' => $this->integer(11)->notNull(),
            'invoken_route' => $this->string(120)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_user_online');
    }
}
