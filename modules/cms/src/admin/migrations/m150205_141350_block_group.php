<?php


use yii\db\Migration;

class m150205_141350_block_group extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_block_group', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(false),
            'identifier' => $this->string(120)->notNull(),
            'created_timestamp' => $this->integer(11)->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_block_group');
    }
}
