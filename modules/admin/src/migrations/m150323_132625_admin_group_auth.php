<?php


use yii\db\Migration;

class m150323_132625_admin_group_auth extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_group_auth', [
            'group_id' => $this->integer(11),
            'auth_id' => $this->integer(11),
            'crud_create' => $this->smallInteger(4),
            'crud_update' => $this->smallInteger(4),
            'crud_delete' => $this->smallInteger(4),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_group_auth');
    }
}
