<?php

use yii\db\Migration;

class m160329_085913_blockgroupfields extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->dropColumn('cms_block', 'system_block');
        $this->addColumn('cms_block_group', 'identifier', 'varchar(120) NOT NULL'); // add unique on release?
        $this->addColumn('cms_block_group', 'created_timestamp', 'int(11)');
    }

    public function safeDown()
    {
        $this->addColumn('cms_block', 'system_block', 'int(11)');
        $this->dropColumn('cms_block_group', 'identifier');
        $this->dropColumn('cms_block_group', 'created_timestamp');
    }
}
