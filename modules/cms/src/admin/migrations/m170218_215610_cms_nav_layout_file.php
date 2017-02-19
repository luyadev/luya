<?php

use yii\db\Migration;

class m170218_215610_cms_nav_layout_file extends Migration
{
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
        $this->addColumn('cms_nav', 'layout_file', $this->string());
    }

    public function safeDown()
    {
        $this->dropColumn('cms_nav', 'layout_file');
    }
}
