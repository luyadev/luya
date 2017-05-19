<?php


use yii\db\Migration;

class m150108_154017_cms_block extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_block', [
            'id' => $this->primaryKey(),
            'group_id' => $this->integer(11)->notNull(),
            'class' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('createTable');
    }
}
