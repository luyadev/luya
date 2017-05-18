<?php


use yii\db\Migration;

class m150122_125429_cms_nav_item_module extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_item_module', [
            'id' => $this->primaryKey(),
            'module_name' => $this->string(255)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_item_module');
    }
}
