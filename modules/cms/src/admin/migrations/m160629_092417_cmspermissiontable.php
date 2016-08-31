<?php

use yii\db\Migration;

class m160629_092417_cmspermissiontable extends Migration
{
    public function safeUp()
    {
        $this->createTable('cms_nav_permission', [
            'group_id' => 'int(11) NOT NULL',
            'nav_id' => 'int(11) NOT NULL',
            'inheritance' => 'tinyint(1) default 0',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_permission');
    }
}
