<?php

use yii\db\Migration;

class m160629_092417_cmspermissiontable extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->createTable('cms_nav_permission', [
            'group_id' => 'int(11) NOT NULL',
            'nav_id' => 'int(11) NOT NULL',
        ]);
    }

    public function safeDown()
    {
    }
}
