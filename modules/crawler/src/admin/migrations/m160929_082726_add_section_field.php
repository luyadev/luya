<?php

use yii\db\Migration;

class m160929_082726_add_section_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('crawler_index', 'group', 'varchar(120)');
        $this->addColumn('crawler_builder_index', 'group', 'varchar(120)');
    }

    public function safeDown()
    {
        $this->dropColumn('crawler_index', 'group');
        $this->dropColumn('crawler_builder_index', 'group');
    }
}
