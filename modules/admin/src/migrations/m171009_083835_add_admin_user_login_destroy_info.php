<?php

use yii\db\Migration;

class m171009_083835_add_admin_user_login_destroy_info extends Migration
{
    public function safeUp()
    {
        $this->dropColumn('admin_user_login', 'session_id'); // Remove in 1.0.1 release!
        $this->addColumn('admin_user_login', 'is_destroyed', $this->boolean()->defaultValue(true));
    }

    public function safeDown()
    {
        $this->addColumn('admin_user_login', 'session_id', $this->string()); // Remove in 1.0.1 release!
        $this->dropColumn('admin_user_login', 'is_destroyed');
    }
}
