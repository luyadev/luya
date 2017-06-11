<?php


use yii\db\Migration;

class m150304_152244_admin_storage_filter extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_storage_filter', [
            'id' => $this->primaryKey(),
            'identifier' => $this->string(100)->notNull()->unique(),
            'name' => $this->string(255),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_storage_filter');
    }
}
