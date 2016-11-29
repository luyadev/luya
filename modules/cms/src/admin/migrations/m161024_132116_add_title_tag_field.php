<?php

use yii\db\Migration;

class m161024_132116_add_title_tag_field extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('cms_nav_item', 'title_tag', 'varchar(255)');
    }

    public function safeDown()
    {
        $this->dropTable('cms_nav_item', 'title_tag');
    }
}
