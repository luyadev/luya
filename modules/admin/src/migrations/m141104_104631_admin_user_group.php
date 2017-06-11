<?php


use yii\db\Migration;

class m141104_104631_admin_user_group extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_user_group', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(11),
            'group_id' => $this->integer(11),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_user_group');
    }
}
