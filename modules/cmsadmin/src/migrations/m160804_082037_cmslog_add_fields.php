<?php

use yii\db\Migration;

class m160804_082037_cmslog_add_fields extends Migration
{
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('cms_log', 'table_name', 'varchar(120)');
        $this->addColumn('cms_log', 'row_id', 'int(11) default 0');
    }

    public function safeDown()
    {
        $this->dropColumn('cms_log', 'table_name');
        $this->dropColumn('cms_log', 'row_id');
    }
}
