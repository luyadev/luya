<?php

use yii\db\Migration;

class m161024_134505_add_description_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('crawler_index', 'description', 'text');
        $this->addColumn('crawler_builder_index', 'description', 'text');
    }

    public function safeDown()
    {
        $this->dropColumn('crawler_index', 'description');
        $this->dropColumn('crawler_builder_index', 'description');
    }
}
