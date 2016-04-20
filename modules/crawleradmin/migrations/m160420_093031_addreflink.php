<?php

use yii\db\Migration;

class m160420_093031_addreflink extends Migration
{
    
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('crawler_index', 'url_found_on_page', 'varchar(255)');
        $this->addColumn('crawler_builder_index', 'url_found_on_page', 'varchar(255)');
    }

    public function safeDown()
    {
        $this->dropColumn('crawler_index', 'url_found_on_page');
        $this->dropColumn('crawler_builder_index', 'url_found_on_page');
    }
}
