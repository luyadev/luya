<?php

use yii\db\Migration;

class m141203_143059_cms_nav extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav', [
            'id' => $this->primaryKey(),
            'nav_container_id' => $this->integer(11)->notNull(),
            'parent_nav_id' => $this->integer(11)->notNull(),
            'sort_index' => $this->integer(11)->notNull(),
            'is_deleted' => $this->boolean()->defaultValue(0),
            'is_hidden' => $this->boolean()->defaultValue(0),
            'is_home' => $this->boolean()->defaultValue(0),
            'is_offline' => $this->boolean()->defaultValue(0),
            'is_draft' => $this->boolean()->defaultValue(0),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav');
    }
}
