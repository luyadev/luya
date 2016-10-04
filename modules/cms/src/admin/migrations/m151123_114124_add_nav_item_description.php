<?php

use yii\db\Schema;
use yii\db\Migration;

class m151123_114124_add_nav_item_description extends Migration
{
    public function up()
    {
        $this->addColumn('cms_nav_item', 'description', 'text');
    }

    public function down()
    {
        echo "m151123_114124_add_nav_item_description cannot be reverted.\n";

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
