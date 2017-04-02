<?php

use yii\db\Migration;

class m160629_092417_cmspermissiontable extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_permission', [
            'group_id' => $this->integer(11)->notNull(),
            'nav_id' => $this->integer(11)->notNull(),
            'inheritance' => $this->boolean()->defaultValue(false),
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_permission');
    }
}
