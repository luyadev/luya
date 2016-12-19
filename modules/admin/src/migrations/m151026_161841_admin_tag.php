<?php

use yii\db\Migration;

class m151026_161841_admin_tag extends Migration
{
    public function safeUp()
    {
        $this->createTable('admin_tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string(120)->notNull()->unique(),
        ]);

        $this->createTable('admin_tag_relation', [
            'tag_id' => $this->integer(11)->notNull(),
            'table_name' => $this->string(120)->notNull(),
            'pk_id' => $this->integer(11)->notNull(),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('admin_tag');
        $this->dropTable('admin_tag_relation');
    }
}
