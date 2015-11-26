<?php

use yii\db\Schema;
use yii\db\Migration;

class m151126_090723_add_is_draft_for_nav extends Migration
{
    public function up()
    {
        $this->addColumn('cms_nav', 'is_draft', 'tinyint(1) default 0');
    }

    public function down()
    {
        echo "m151126_090723_add_is_draft_for_nav cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
