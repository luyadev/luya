<?php


use yii\db\Migration;

class m141104_104622_admin_group extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_group', [
            'id' => 'pk',
            'name' => $this->string(255)->notNull(),
            'text' => $this->text(),
            'is_deleted' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_group');
    }
}
